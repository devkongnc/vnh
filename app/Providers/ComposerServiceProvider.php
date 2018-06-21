<?php

namespace App\Providers;

use App\Apartment;
use App\Estate;
use App\Page;
use App\Resource;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use LaravelLocalization;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('current_locale', LaravelLocalization::getCurrentLocale());
        view()->composer('*', function($view) {
            $static_pages = Cache::rememberForever('static_pages', function() {
                return Page::withoutGlobalScopes()->public()->get()->keyBy('id')->all();
            });

            $view->with([
                'all_locales' => LaravelLocalization::getSupportedLocales(),
                'pages_by_id' => $static_pages,
            ]);
        });
        view()->composer('partials.search_box', function($view) {
            $data['total_estate'] = Cache::rememberForever('total_estate', function() {
                return Estate::withoutGlobalScopes()->public()->count();
            });
            $data['apartments_select'] = Cache::rememberForever('apartments_select', function() {
                return Apartment::withoutGlobalScopes()->public()->get();
            });
            $selectedTerm = (array) json_decode(option('search'), true);
            $selected = [];
            foreach ($selectedTerm as $item) {
                $selected[$item] = config('real-estate.' . $item);
            }
            $data['selected'] = $selected;
            /*$selected = config('real-estate');
            $selected = array_filter($selected, function($item) { return $item['type'] === 'single'; });*/

            $view->with($data);
        });
        view()->composer('partials.three-grid', function($view) {
            $data['basic'] = collect(config('real-estate'))->filter(function ($value, $key) {
                return $value['group'] === 'basic' and in_array($key, ['type', 'size', 'beds', 'baths', 'time_to_cbd']);
            });
            $data['equipments'] = collect(config('real-estate'))->filter(function($item, $key) { return $item['group'] == 'details' and $key !== 'surroundings'; });

            $view->with($data);
        });
        view()->composer('partials.three-grid-map', function($view) {
            $data['basic'] = collect(config('real-estate'))->filter(function ($value, $key) {
                return $value['group'] === 'basic' and in_array($key, ['type', 'size', 'beds', 'baths', 'time_to_cbd']);
            });
            $data['equipments'] = collect(config('real-estate'))->filter(function($item, $key) { return $item['group'] == 'details' and $key !== 'surroundings'; });

            $view->with($data);
        });
        view()->composer(['layout.header', 'about.base', 'admin.static-page.menu'], function($view) {
            $menu = (array) json_decode(option('page_menu'));
            $view->with('menu', $menu);
        });
        view()->composer('home', function($view) {
            if (option('home_banner') === 'slider') {
                $slides = json_decode(option('home_slider'));
                $resources = Resource::whereIn('id', array_pluck((array) $slides, 'id'))->get()->keyBy('id')->all();
                $data['slides'] = $slides;
                $data['resources'] = $resources;
            } else {
                $data['video'] = json_decode(option('home_video'));
            }

            $data['new_arrival'] = Cache::remember('new_arrival', 720, function() {
                return Estate::whereDate('created_at', '=', Carbon::today())->count();
            });

            $data['total_estate'] = Cache::remember('total_estate', 720, function() {
                return Estate::withoutGlobalScopes()->public()->count();
            });

            $view->with($data);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
