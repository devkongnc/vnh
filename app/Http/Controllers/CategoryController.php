<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('resource')->paginate(20);
        \SEO::setTitle(trans('menu.categories'));
        return view('category.index', compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Request $request, $permalink)
    {
        $category = Category::withoutGlobalScopes()->private()->with('resource')->where('permalink', $permalink)->firstOrFail();
        $query = $category->results();
        # Order kết quả
        $order = $request->get('order', session('search_order', 'id-desc'));
        session(['search_order' => $order]);
        $orderExploded = explode("-", $order);
        # Giới hạn thuộc tính sắp xếp
        if (in_array($orderExploded[0], config('override.order field'))) $query = $query->orderBy($orderExploded[0], $orderExploded[1]);
        else $query->orderBy('id', 'desc');
        # Phân trang
        $results = $query->paginate(20);

        \SEO::setTitle($category->title);
        \SEO::setDescription($category->meta_description);
        \SEO::metatags()->addKeyword(explode(',', $category->meta_keywords));
        \SEO::metatags()->setDescription($category->meta_description);
        \SEO::opengraph()->setUrl($request->fullUrl());
        if ($category->resource_id !== NULL) \SEO::opengraph()->addImage($category->resource->url);
        return view('category.show', compact('category', 'results', 'order'));
    }

    public function search(Request $request) {
        $title = htmlentities(strip_tags(trim($request->title)));
        $categories = Category::whereHas('locales', function($query) use($title) {
            $query->whereRaw("UPPER(title) LIKE UPPER('%" . $title . "%')");
        })->with('resource')->paginate(20)->appends(['title' => $title]);
        return view('category.index', compact('categories'));
    }
}
