<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Estate;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\CategoryModelRequest;
use App\Resource;
use App\TermRepository;
use Cache;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Category::with('user')->orderBy('id', 'desc')->get();
        $data['video'] = (option('home_video')) ? json_decode(option('home_video')) : '';
        $data['slides'] = (option('home_slider')) ? json_decode(option('home_slider')) : '';
        $data['resources'] = Resource::whereIn('id', array_pluck((array)$data['slides'], 'id'))->get()->keyBy('id')->all();
        $data['robots'] = File::get(public_path('robots.txt'));
        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('admin.category.create', array_merge(compact('category'), $this->prepareTerm()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryModelRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryModelRequest $request)
    {
        $category = Category::create($request->all());
        return redirect()->action('Admin\CategoryController@edit', $category->id)
            ->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', array_merge(compact('category'), $this->prepareTerm()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryModelRequest|Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(CategoryModelRequest $request, $id)
    {
        try {

            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->withInput()
                    ->withFlashData(['status' => 'error', 'message' => trans('admin.message.error.not_found_id')]);
            }
            $aSqlData = (array)$category->sql_data;
            if (array_key_exists('ids', $aSqlData) && $aSqlData['ids'] != null) {
                $aOldIdEstate = explode(",", $aSqlData['ids']);
            } else {
                $aOldIdEstate = [];
            }

            $aNewIdEstate = $request->get('sql_data')['ids'];
            if ($aNewIdEstate == null) {
                $aNewIdEstate = [];
            } else {
                $aNewIdEstate = explode(",", $aNewIdEstate);
            }

            $aOldIdEstate = array_diff($aOldIdEstate, $aNewIdEstate);

            foreach ($aNewIdEstate as $idEs) {
                $estate = Estate::where('product_id', $idEs)->first();
                if ($estate) {
                    if ($estate->category_ids == null) {
                        $aIdEs = [];
                    } else {
                        $aIdEs = explode(",", $estate->category_ids);
                    }
                    if (!in_array($id, $aIdEs)) {
                        array_push($aIdEs, $id);
                        $estate->update(["category_ids" => implode(",", $aIdEs)]);
                    }
                } else {
                    return redirect()->back()->withInput()
                        ->withFlashData(['status' => 'error',
                            'message' => trans('admin.message.error.not_found_estateId') . " (" . $idEs . ")"]);
                }
            }

            foreach ($aOldIdEstate as $idEs) {
                $estate = Estate::where('product_id', $idEs)->first();
                if ($estate) {
                    $aIdEs = explode(",", $estate->category_ids);
                    if (in_array($id, $aIdEs) != false) {
                        foreach (array_keys($aIdEs, $id) as $key) {
                            unset($aIdEs[$key]);
                        }
                        $estate->update(["category_ids" => implode(",", $aIdEs)]);
                    }
                }
            }

            $category->update($request->except(['_method', '_token']));

            return redirect()->action('Admin\CategoryController@edit', $category->id)
                ->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);

        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . ' Line: ' . $e->getLine();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->action('Admin\CategoryController@index')
            ->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);
    }

    private function prepareTerm()
    {
        $store = new TermRepository([]);
        $term_collection = new Collection($store->currentData);
        $above = $term_collection->filter(function ($item, $key) {
            return $item['type'] !== 'multiple' and $key !== 'size';
        });
        $below = $term_collection->filter(function ($item) {
            return $item['type'] == 'multiple';
        });
        return compact('below', 'above');
    }

    public function home(Request $request, $option)
    {
        switch ($option) {
            case 'home_slider':
                $images = [];
                if ($request->has('images')) {
                    $images = $request->images;
                    $firsts = array_map(function ($item) {
                        return getLocaleString($item);
                    }, array_values($request->first));
                    $seconds = array_map(function ($item) {
                        return getLocaleString($item);
                    }, array_values($request->second));
                    array_walk($images, function (&$item, $key) use ($firsts, $seconds) {
                        $item = [
                            'id' => $item,
                            'first' => $firsts[$key],
                            'second' => $seconds[$key]
                        ];
                    });
                }
                setOption('home_banner', 'slider');
                setOption('home_slider', json_encode($images, JSON_FORCE_OBJECT));
                break;
            case 'home_video':
                $this->validate($request, [
                    'video' => 'mimetypes:video/mp4,video/avi',
                    'first' => 'max:255',
                    'second' => 'max:255'
                ]);

                $video = json_decode(option('home_video'));
                $url = $video ? $video->url : '';

                if ($request->hasFile('video')) {
                    $dir = 'video';
                    File::cleanDirectory(public_path('upload/' . $dir));
                    $newfilename = cleanName($request->file('video')->getClientOriginalName());
                    $request->file('video')->move(public_path('upload/' . $dir), $newfilename);
                    $url = "/upload/$dir/$newfilename";
                }

                setOption('home_banner', 'video');
                setOption('home_video', json_encode([
                    'url' => $url,
                    'first' => getLocaleString($request->first),
                    'second' => getLocaleString($request->second)
                ], JSON_FORCE_OBJECT));

                return redirect()->action('Admin\CategoryController@index')
                    ->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
                break;
            case 'partner':
                setOption('partner', $request->partner);
                break;
            case 'robots':
                File::put(public_path('robots.txt'), $request->robots);
                break;
            default:
                break;
        }

        return redirect()->action('Admin\CategoryController@index')
            ->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
    }
}
