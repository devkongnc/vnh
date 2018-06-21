<?php

namespace App\Providers;

use App\Apartment;
use App\User;
use App\VietnamHouse\Auth\CustomUserProvider;
use Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        Auth::provider('custom', function($app, array $config) {
            return new CustomUserProvider($app['hash'], $config['model']);
        });

        $gate->define('show_policy', function ($user, $model) {
            if ($user == null) return $model->status == Apartment::VISIBILITY_PUBLIC;
            if ($user->level >= User::USER_CONTENT) {
                return true;
            }
            return $model->status == Apartment::VISIBILITY_PUBLIC || $user->id === $model->user_id;
        });

        $gate->define('manage-user', function ($user) {
            return $user->is_admin;
        });
    }
}
