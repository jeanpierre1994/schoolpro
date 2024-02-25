<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;


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
        View::composer(['index', 'frontend.inc.user_footer', 'frontend.inscriptions.form', "auth.login"], function ($view) {
            $view->with([
                'etablissement' => getEtablissement(),
            ]);
        });

        Paginator::useBootstrap();

        Gate::after(function($user){
            return $user->hasRole('super-admin');
        });
    }
}
