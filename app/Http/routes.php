<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web'], 'prefix' => LaravelLocalization::setLocale()], function () {
    # Homepage
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::post('clear-cache', 'HomeController@clearCache')->middleware('auth');

    # Search
    Route::get('search-advanced', ['as' => 'search-advanced', 'uses' => 'HomeController@searchForm']);
    Route::get('search', 'HomeController@search');
    Route::get('search-map', 'SearchMapController@search');
    Route::get('desktop', 'HomeController@desktop');

    # Page
    Route::group(['prefix' => 'support'], function () {
        Route::get('{permalink?}', ['uses' => 'HomeController@about']);
    });
    Route::group(['prefix' => 'company'], function () {
        Route::post('contact', 'HomeController@contact');
        Route::get('sitemap', function () {
            \SEO::setTitle(trans('menu.sitemap'));
            return view('about.sitemap');
        });
        Route::get('{permalink?}', ['uses' => 'HomeController@about']);
    });
    Route::get('sitemap.xml', function () {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    });
    Route::get('sitemap-{model}.xml', 'HomeController@sitemap');

    # RealEstate
    Route::group(['prefix' => 'office'], function () {
        Route::get('', 'RealEstateController@index');
        //Route::get('new', 'RealEstateController@arrival');
        Route::get('{id}', 'RealEstateController@show');
        Route::post('landlord', 'RealEstateController@landlord');
        Route::get('{id}/amp', 'RealEstateController@showAmp');
    });

    # Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('', 'CategoryController@index');
        Route::get('search', 'CategoryController@search');
        Route::get('{permalink}', 'CategoryController@show');
    });

    # Review
    Route::group(['prefix' => 'blog'], function () {
        Route::get('', 'ReviewController@index');
        Route::get('search', 'ReviewController@search');
        Route::get('{category}', 'ReviewController@category');
        Route::get('{category}/{permalink}', 'ReviewController@show');
    });

    # Authenticate
    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController'
    ]);

    # Admin
    Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function () {
        Route::get('/', ['as' => 'admin.dashboard', function () {
            $contacts = App\Contact::whereDate('created_at', '=', Carbon\Carbon::today())->orderBy('id', 'desc')->get();
            $estates = App\Estate::with('user')->whereDate('created_at', '=', Carbon\Carbon::today())->orderBy('id', 'desc')->take(100)->get();
            $reviews = App\Review::with('user')->whereDate('created_at', '=', Carbon\Carbon::today())->orderBy('id', 'desc')->get();
            return view('admin.dashboard', compact('contacts', 'estates', 'reviews'));
        }]);

        Route::group(['prefix' => 'resource'], function () {
            Route::post('upload', 'ResourceController@upload');
        });

        Route::delete('{type}/term', 'TermController@destroy');
        Route::resource('{type}/term', 'TermController', ['except' => ['destroy']]);

        Route::group(['prefix' => 'real-estate'], function () {
            Route::any('search', 'RealEstateController@search');
            Route::post('export', 'RealEstateController@export');
        });
        Route::resource('real-estate', 'RealEstateController');

        Route::group(['prefix' => 'review'], function () {
            Route::post('export', 'ReviewController@export');
            Route::put('preview', 'ReviewController@preview');
        });
        Route::resource('review', 'ReviewController');

        Route::group(['prefix' => 'category'], function () {
            Route::get('{category}/result', 'CategoryController@result');
            Route::post('home/{option}', 'CategoryController@home');
            Route::post('export', 'CategoryController@export');
        });
        Route::resource('category', 'CategoryController');

        Route::group(['prefix' => 'static-page'], function () {
            Route::any('menu', 'PageController@menu');
            Route::post('{id}/preview', 'PageController@preview');
        });
        Route::resource('static-page', 'PageController');

        Route::resource('user', 'UserController');

        Route::post('contact/export', 'ContactController@export');
        Route::resource('contact', 'ContactController');
    });

    /*Route::group(['prefix' => 'resource'], function(){
        Route::get('thumb', 'ResourceController@thumb');
    });

    Route::get('lists', function(){
        return view('lists');
    });*/

});
