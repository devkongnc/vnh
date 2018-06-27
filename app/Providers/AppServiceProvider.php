<?php

namespace App\Providers;

use Cache;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\ServiceProvider;
use Log;
use Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Estate::saved(function ($estate) {
            Cache::forget('new_arrival');
            Cache::forget('total_estate');
            Cache::forget('view.home');
            /*if ($estate->status == Estate::VISIBILITY_PUBLIC or $estate->status == Estate::VISIBILITY_PRIVATE)
                Queue::push("App\\Estate@updateEstate");*/
        });

        \App\Category::saved(function ($category) {
            Queue::push('App\Category@updateCategory', $category);
        });
        \App\Page::saved(function ($page) {
            Cache::forget('static_pages');
            # Trường hợp root permalink thêm dấu chấm ở cuối, xem lại HomeController@about Cache key
            $cache_key = str_replace('/', '.', $page->permalink, $count);
            if ($count == 0) $cache_key .= ".";
            Cache::forget('page.' . $cache_key);
        });
        Queue::after(function (JobProcessed $event) {
            Log::info($event->data['job'] . ' ' . json_encode($event->data['data']));
            $event->job->delete();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
