<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use App\Models\TahunAjaran;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Http\Request;
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
    public function boot(Request $request)
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        $roles = Role::all();
        View::share('roles', $roles);

        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');

        view()->composer('*', function($view)
        {
            if (\Auth::user()) {
                $tahun_ajarans = TahunAjaran::all();
                View::share('tahun_ajarans', $tahun_ajarans);
            }
        });
    }
}
