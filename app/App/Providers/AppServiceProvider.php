<?php

namespace CreatyDev\App\Providers;

use Illuminate\Support\ServiceProvider;
use CreatyDev\Domain\Users\Models\Role;
use CreatyDev\Domain\Users\Observers\RoleObserver;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Debugbar::disable();
        Schema::defaultStringLength(191);
        //model observers
//        Category::observe(CategoryObserver::class);
//        Tag::observe(TagObserver::class);
        Role::observe(RoleObserver::class);
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
