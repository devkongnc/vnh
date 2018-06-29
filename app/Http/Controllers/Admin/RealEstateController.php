<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Estate;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEstateRequest;
use App\Option;
use App\Resource;
use App\TermRepository;
use DB;
use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Psy\Exception\ErrorException;

class RealEstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total  = Estate::count('id');
        $hidden = Estate::where('status', Estate::VISIBILITY_HIDDEN)->count('id');

        if ($request->ajax()) {
            $query = Estate::with('user')->leftJoin('estate_sticky', 'estates.id', '=', 'estate_sticky.estate_id')->select('estates.*', 'estate_sticky.created_at as sticky_at');

            if ($request->has('area') or $request->has('type')) {
                if ($request->has('area')) $query = $query->where('area', $request->area);
                if ($request->has('type')) $query = $query->where('type', $request->type);
                $filtered = $query->count();
            }

            if ('' !== $search = $request->search['value']) {
                $query = $query->whereHas('locales', function($q) use($search) {
                    $q->where('title', 'LIKE', "%{$search}%")->orWhere('product_id', $search);
                });
                $filtered = $query->count();
            }

            if ($request->has('order')) {
                $order_map = [
                    1 => 'product_id',
                    3 => 'price',
                    4 => 'status',
                    5 => 'sticky_at',
                    7 => 'id'
                ];
                $order = $request->order[0];
                $query = $query->orderBy($order_map[$order['column']], $order['dir']);
            } else $query = $query->orderBy('id', 'desc');

            $estates = $query->skip($request->start)->take($request->length)->get();
            $result = [];
            foreach ($estates as $estate) {
                $result[] = [
                    null,
                    $estate->product_id,
                    link_to(action('Admin\RealEstateController@edit', $estate->id), $estate->title)->toHtml(),
                    $estate->price,
                    $estate->visibility,
                    $estate->sticky_at ? '<i class="fa fa-check-circle fa-2" aria-hidden="true"></i>' : '',
                    !empty($estate->user) ? $estate->user->name : '',
                    $estate->created_at,
                    link_to(action('Admin\RealEstateController@edit', $estate->id), trans('admin.common.edit'), ['class' => 'btn btn-primary']) .
                    link_to(action('RealEstateController@show', $estate->product_id), trans('admin.common.view'), ['class' => 'btn btn-default', 'target' => '_blank'])
                ];
            }
            return response()->json([
                'data'            => $result,
                "recordsTotal"    => $total,
                'recordsFiltered' => isset($filtered) ? $filtered : $total
            ]);
        }
        return view('admin.real-estate.index', array_merge(compact('total', 'hidden'), $this->prepareTerm()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estate = new Estate();
        $estate->product_id = (int) Estate::max('product_id') + 1;
        return view('admin.real-estate.create', array_merge(compact('estate'), $this->prepareTerm()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveEstateRequest $request)
    {
        DB::beginTransaction();
        try {
            $new_estate = Estate::create(
                array_merge(
                    $request->except(['term', 'sticky', 'category_ids', '_method', '_token']),
                    (array) $request->get('term'),
                    ['category_ids' => implode(",", (array)$request->get('category_ids'))]
                 )
            );

            //adding category
            if (!empty($request->get('category_ids')) &&  count($request->get('category_ids')) > 0) {
                foreach ($request->get('category_ids') as $idCate) {
                    $category = Category::find($idCate);
                    if ($category) {
                        $sqlData = (array)$category->sql_data;
                        if (!array_key_exists('ids', $sqlData) || $sqlData['ids'] == null) { $aIdEstate = [];}
                            else { $aIdEstate = explode(",", $sqlData['ids']); }

                        if (!in_array($new_estate->product_id, $aIdEstate)) {
                            array_push($aIdEstate, $new_estate->product_id);
                        }

                        $sqlData['ids'] = implode(",", $aIdEstate);
                        $category->update(['sql_data' => $sqlData]);
                    }
                }
            }

            if ($request->has('images')) {
                foreach ($request->images as $key => $value) {
                    $images[$value] = ['order' => $key];
                }
                $new_estate->resources()->sync($images);
                rename(sprintf(Resource::dir('images'), $request->_token), sprintf(Resource::dir('images'), $new_estate->product_id));
                Resource::whereIn('id', (array) $request->images)->update(['folder' => "images/{$new_estate->product_id}/"]);
            }

            if ($request->sticky === true) $new_estate->sticky()->create([]);
            DB::commit();
            return redirect()->action('Admin\RealEstateController@edit', $new_estate->id)->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withInput()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estate = Estate::findOrFail($id);
        return view('admin.real-estate.edit', array_merge(compact('estate'), $this->prepareTerm()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveEstateRequest $request, $id)
    {
        try {
            $estate = Estate::findOrFail($id);

            //Check product_id exists
            $product_id_new = !empty($request->product_id) ? $request->product_id : 0;
            $product_id_old = $estate->product_id;
            $flag_change_product_id = false;
            if ($product_id_new != $product_id_old) {
                $flag_change_product_id = true;
            }

            //detect Old & New category add or remove
            if ($request->get('category_ids') != null) {
                $aIdCate = $request->get('category_ids');
            } else {
                $aIdCate = [];
            }

            $aOldIdCate = $estate->category_ids;
            if ($aOldIdCate == null) {
                $aOldIdCate = [];
            } else {
                $aOldIdCate = explode(",", $aOldIdCate);

            }
            $aDiffOld = array_diff($aOldIdCate, $aIdCate);

            //adding category
            foreach ($aIdCate as $idCate) {
                $category = Category::find($idCate);
                if ($category) {
                    $sqlData = (array)$category->sql_data;
                    if (!array_key_exists('ids', $sqlData) || $sqlData['ids'] == null) {
                        $aIdEstate = [];
                    } else {
                        $aIdEstate = explode(",", $sqlData['ids']);
                    }

                    $find_item = array_search($product_id_old, $aIdEstate);
                    if ($flag_change_product_id && $find_item !== false) {
                        unset($aIdEstate[$find_item]);
                    }

                    if (!in_array($product_id_new, $aIdEstate)) {
                        array_push($aIdEstate, $product_id_new);
                    }

                    $sqlData['ids'] = implode(",", $aIdEstate);
                    $category->update(['sql_data' => $sqlData]);
                }
            }

            //removing category
            foreach ($aDiffOld as $idCate) {
                $category = Category::find($idCate);
                if ($category) {
                    $sqlData = (array)$category->sql_data;
                    if (array_key_exists('ids', $sqlData) && $sqlData['ids'] != null) {
                        $aIdEstate = explode(",", $sqlData['ids']);

                        $find_item = array_search($product_id_old, $aIdEstate);
                        if (in_array($product_id_old, $aIdEstate)) {
                            unset($aIdEstate[$find_item]);
                        }
                        $sqlData['ids'] = implode(",", $aIdEstate);
                        $category->update(['sql_data' => $sqlData]);
                    }
                }
            }

            $merge_request = array_merge(
                            $request->except(['term', 'sticky', 'category_ids', '_method', '_token']),
                            (array)$request->get('term'),
                            ['category_ids' => implode(",", $aIdCate)]);
            if (!empty($merge_request['anniversary'])) {
                $merge_request['anniversary'] = date('Y-m-d', strtotime(str_replace('/', '-', $merge_request['anniversary'])));
            }

            $estate->update($merge_request);

            $images = [];
            if ($request->has('images')) {
                foreach ($request->images as $key => $value) {
                    $images[$value] = ['order' => $key];
                }
            }
            $estate->resources()->sync($images);

            if ($request->sticky === true and $estate->is_sticky === false) $estate->sticky()->create([]);
            elseif ($request->sticky === false and $estate->is_sticky === true) $estate->sticky()->delete();

            return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
        } catch (\Exception $e) {
            echo 'Error: '.$e->getMessage().' Line: '.$e->getLine();
            exit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estate = Estate::findOrFail($id);
        File::deleteDirectory(public_path(sprintf(Resource::dir('images'), $estate->product_id)));
        $estate->delete();
        return redirect()->action('Admin\RealEstateController@index')->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);
    }

    public function search(Request $request) {
        $selected = json_decode(option('search'), true);
        $terms = array_filter(config('real-estate'), function($item) { return $item['type'] !== 'text'; });
        switch ($request->method()) {
            case 'GET':
                return view('admin.real-estate.search', compact('selected', 'terms'));
            case 'POST':
                $selected = $request->get('selected', []);
                setOption('search', json_encode($selected, JSON_FORCE_OBJECT));
                /*$fileContent = file_get_contents(config_path('search.php'));
                $lines = explode("\n", $fileContent);
                $selectedAsString = "        '" . implode("', '", $selected) . "'\r";
                $lines[3] = $selectedAsString;
                file_put_contents(config_path('search.php'), implode("\n", $lines));*/
                $request->session()->flash('flash_data', ['status' => 'success', 'message' => trans('admin.message.success.update')]);
                return back();
                //return view('admin.real-estate.search', compact('selected', 'terms'));
        }
    }

    private function prepareTerm(){
        $store = new TermRepository([]);
        $term_collection = new Collection($store->currentData);
        $above = $term_collection->filter(function($item, $key){
            return $item['type'] != 'multiple';
        });
        $below = $term_collection->filter(function($item){
            return $item['type'] == 'multiple';
        });
        return compact('below', 'above');
    }

    public function export() {
        $estates = Estate::all();
        $rows = [];
        foreach ($estates as $index => $estate) {
            $rows[] = [
                $index + 1,
                'ID'                                 => $estate->product_id,
                trans('admin.common.title')          => $estate->title,
                trans('admin.apartment.price')       => $estate->price,
                trans('admin.common.status')         => strip_tags($estate->visibility),
                trans('admin.common.created at')     => $estate->created_at,
                trans('admin.apartment.description') => $estate->description
            ];
        }
        Excel::create(trans('admin.entity.estate') . '_' . date('d-m-Y-H-i-s'), function($excel) use($rows) {
            $excel->sheet('Sheet1', function($sheet) use($rows) {
                $sheet->fromArray($rows);
            });
        })->download('xlsx');
        return;
    }

}
