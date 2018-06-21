<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request) {
        $categories = [];
        $reviews = Review::with('resource')->orderBy('timestamp', 'desc')->paginate(18);
        \SEO::setTitle(trans('menu.review'));
        return view('review.index', compact('reviews', 'categories'));
    }

    public function category($slug) {
        $categories = array_flip(config('override.category'));
        if (!array_key_exists($slug, $categories)) return;
        $category = $categories[$slug];
        $reviews = Review::with('resource')->where('categories', 'LIKE', "%{$category}%")->orderBy('timestamp', 'desc')->paginate(18)/*->appends(['category' => $category])*/;
        $categories = [$category];
        \SEO::setTitle(trans('menu.review'));
        return view('review.index', compact('reviews', 'categories'));
    }

    public function show(Request $request, $category, $permalink) {
        $review             = Review::withoutGlobalScopes()->private()->with('user')->where('permalink', $permalink)->firstOrFail();
        $data['review']     = $review;
        $data['previous']   = Review::where('id', '<', $review->id)->orderBy('id', 'desc')->first();
        $data['next']       = Review::where('id', '>', $review->id)->first();
        $data['categories'] = $review->categories;
        \SEO::setTitle($review->title)->setDescription(\Illuminate\Support\Str::words($review->description, 10));
        \SEO::opengraph()->setUrl($request->fullUrl())->addImage($review->resource_id ? $review->resource->url : NULL);
        \SEO::twitter()->setUrl($request->fullUrl())->addImage($review->resource_id ? $review->resource->url : NULL);
        return view('review.show', $data);
    }

    public function search(Request $request) {
        $title = htmlentities(strip_tags(trim($request->title)));
        $categories = explode(',', \Request::get('categories', ''));
        $reviews = Review::whereHas('locales', function($query) use($title) {
            $query->whereRaw("UPPER(title) LIKE UPPER('%{$title}%')");
        })->with('resource')->paginate(20)->appends(['title' => $title]);
        return view('review.index', compact('reviews', 'categories'));
    }

}
