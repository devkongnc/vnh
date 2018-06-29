<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push(trans('menu.home'), URL::action('HomeController@home'));
});

// Sitemap
Breadcrumbs::register('sitemap', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.sitemap'), url('sitemap'));
});

// Service
Breadcrumbs::register('service', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.service'), url('service'));
});

// Search
Breadcrumbs::register('search', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.search'), URL::action('HomeController@searchForm'));
});

// Results
Breadcrumbs::register('result', function($breadcrumbs)
{
    $breadcrumbs->parent('search');
    $breadcrumbs->push(trans('menu.result'), URL::action('HomeController@search'));
});

// Real Estate
Breadcrumbs::register('arrival', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.arrival'), URL::action('RealEstateController@index'));
});
Breadcrumbs::register('estate', function ($breadcrumbs, $estate) {
    $breadcrumbs->parent('home');

    $breadcrumbs->push($estate->area, $estate->area_permalink);
    $searchParams = [
        'term' => [
            'area' => [$estate->getOriginal('area')]
        ]
    ];
    $breadcrumbs->push($estate->title, URL::action('RealEstateController@show', $estate->product_id));
});

// Home > Categories
Breadcrumbs::register('categories', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.categories'), URL::action('CategoryController@index'));
});
Breadcrumbs::register('category', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('categories');
    $breadcrumbs->push($page->title, URL::action('CategoryController@show', $page->permalink));
});



// Reviews
Breadcrumbs::register('reviews', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.review'), URL::action('ReviewController@index'));
});
//
Breadcrumbs::register('review-category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('reviews');
    $breadcrumbs->push(trans('admin.review.categories.' . $category), action('ReviewController@category', config('override.category.' . $category)));
});
//
Breadcrumbs::register('review', function($breadcrumbs, $review)
{
    $breadcrumbs->parent('reviews');
    $breadcrumbs->push(trans('admin.review.categories.' . $review->category), action('ReviewController@category', config('override.category.' . $review->category)));
    $breadcrumbs->push($review->title, action('ReviewController@category', $review->category_slug));
});

//About page
Breadcrumbs::register('about-company', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('menu.review'), URL::action('ReviewController@index'));
});
Breadcrumbs::register('about-page', function($breadcrumbs, $page) {
    $breadcrumbs->parent('home');
    if ($page->permalink != 'support' && str_contains($page->permalink, 'support')) {
        $breadcrumbs->push(trans('menu.support'), LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), url('support')));
    }
    if ($page->permalink != 'company' && str_contains($page->permalink, 'company')) {
        $breadcrumbs->push(trans('menu.company'), LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), url('company')));
    }
    $breadcrumbs->push($page->title, url($page->permalink));
});
