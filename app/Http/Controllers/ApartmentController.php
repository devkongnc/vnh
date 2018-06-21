<?php

namespace App\Http\Controllers;

use App\Apartment;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Apartment::with(['resource'])->orderBy('sticky', 'desc')->orderBy('recommend', 'asc')->orderBy('permalink', 'asc');
        if ($request->has('area') || $request->has('name')) {
            $area = abs((int) $request->area);
            $name = $request->get('name', null);
            if (!$name == null) {
                $name = "%" . strtolower($name) . "%";
                $query = $query->with('locales')->whereHas('locales', function($query) use ($name) {
                    return $query->where('locale', \LaravelLocalization::getCurrentLocale())->whereRaw("LOWER(title) LIKE '{$name}'");
                });
            }
            if ($area != 0) {
                $query = $query->where('area', $area);
            }
            $apartments = $query->paginate(24)->appends(['area' =>  $area]);
        } else $apartments = $query->paginate(24);
        \SEO::setTitle(trans('menu.apartments'));
        return view('apartment.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Apartment $apartment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Request $request, $permalink)
    {
        # Order kết quả
        $order = $request->get('order', session('search_order', 'id-desc'));
        session(['search_order' => $order]);
        $orderExploded = explode("-", $order);
        //$data = Cache::remember("view.apartment.$permalink", 1440, function() use($permalink, $order, $orderExploded) {
            $apartment = Apartment::withoutGlobalScopes()->private()->with('resources')->where('permalink', $permalink)->firstOrFail();
            $data['apartment'] = $apartment;
            $query = $apartment->estates()->with('resources');
            # Giới hạn thuộc tính sắp xếp

            if (in_array($orderExploded[0], config('override.order field'))) {
                $query = $query->orderBy($orderExploded[0], $orderExploded[1]);
            }
            else {
                $query = $query->orderBy('id', 'desc');
            }
            $data['order'] = $order;
            # Phân trang
            //$estates = $query->paginate(20);
            $data['estates'] = $query->get();

            $data['terms'] = new Collection(\Config::get('apartment'));
            /*$terms = $configTerms->groupBy(function ($item){
                return $item['group'];
            });
            dd($configTerms->filter(function ($item) {
                return $item['group'] === 'basic';
            }));*/
          //  return $data;
        //});


        \SEO::setTitle($data['apartment']->title);
        \SEO::setDescription(\Illuminate\Support\Str::words($data['apartment']->description, 10));
        \SEO::opengraph()->setUrl($request->fullUrl());
        if ($data['apartment']->resource_id !== NULL) \SEO::opengraph()->addImage($data['apartment']->resources->first()->url);

        return view('apartment.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
