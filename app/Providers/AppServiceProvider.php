<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');

        Gate::define('Admin', function (User $user) {
            return $user->role == '1';
        });
        Gate::define('Karyawan', function (User $user) {
            return $user->role == '2';
        });
        Gate::define('Customer', function (User $user) {
            return $user->role == '3';
        });
    }
}
