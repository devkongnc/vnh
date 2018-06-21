<?php

namespace App\Http\Controllers\Admin;

use App\Apartment;
use App\Estate;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveApartmentRequest;
use App\Resource;
use DB;
use Excel;
use File;
use Illuminate\Support\Collection;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::with('user')->orderBy('id', 'desc')->get();
        return view('admin.apartment.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartment = new Apartment();
        $apartment->product_id = (int) Apartment::max('product_id') + 1;
        $terms = $this->_prepareTerms();
        return view('admin.apartment.create', compact('apartment', 'terms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveApartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $new_apartment = Apartment::create($request->all());
            if ($request->has('images')) {
                foreach ($request->images as $key => $value) {
                    $images[$value] = ['order' => $key];
                }
                $new_apartment->resources()->sync($images);
                rename(public_path(sprintf(Resource::dir('condo'), $request->_token)), public_path(sprintf(Resource::dir('condo'), $new_apartment->id)));
                Resource::whereIn('id', (array) $request->images)->update(['folder' => "condo/{$new_apartment->id}/"]);
            }
            DB::commit();
            return redirect()->action('Admin\ApartmentController@edit', $new_apartment->id)->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
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
        $apartment = Apartment::with('resources')->findOrFail($id);
        $terms = $this->_prepareTerms();
        return view('admin.apartment.edit', compact('apartment', 'terms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveApartmentRequest $request, $id)
    {
        $apartment = Apartment::findOrFail($id);
        $images = [];
        DB::beginTransaction();
        try {
            if ($request->has('images')) {
                foreach ($request->images as $key => $value) {
                    $images[$value] = ['order' => $key];
                }
            }
            /*if ($request->has('estates')) {
                $apartment->estates()->whereNotIn('product_id', $request->estates)->update(['apartment_id' => NULL]);
                Estate::whereIn('product_id', $request->estates)->update(['apartment_id' => $apartment->id]);
            }*/
            $apartment->update($request->all());
            $apartment->resources()->sync($images);
            DB::commit();
            return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withInput()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()]);
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
        $apartment = Apartment::findOrFail($id);
        File::deleteDirectory(public_path(sprintf(Resource::dir('condo'), $apartment->id)));
        $apartment->delete();
        return redirect()->action('Admin\ApartmentController@index')->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);
    }

    public function term() {
        $config = config('apartment');
        return view('admin.apartment.term', compact('config'));
    }

    private function _prepareTerms() {
        $terms = new Collection(\Config::get('apartment'));
        return $terms;
        /*return $terms->groupBy(function ($item) {
            return $item['group'];
        }, true);*/
    }

    public function export() {
        $apartments = Apartment::all();
        $rows = [];
        foreach ($apartments as $index => $apartment) {
            $rows[] = [
                $index + 1,
                'ID'                                 => $apartment->product_id,
                trans('admin.common.title')          => $apartment->title,
                trans('admin.apartment.district')    => $apartment->area_text,
                trans('admin.common.status')         => strip_tags($apartment->visibility),
                trans('admin.common.created at')     => $apartment->created_at,
                trans('admin.apartment.description') => $apartment->description
            ];
        }
        Excel::create(trans('admin.entity.apartment') . '_' . date('d-m-Y-H-i-s'), function($excel) use($rows) {
            $excel->sheet('Sheet1', function($sheet) use($rows) {
                $sheet->fromArray($rows);
            });
        })->download('xlsx');
        return;
    }
}
