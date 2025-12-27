<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\ShorterLink;
use App\Observers\ShorterLinkObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ShorterLink::observe(ShorterLinkObserver::class);
        Gate::define('isSuperAdmin', function ($user) {
            return $user->roles()->where('name', 'super_admin')->exists();
        });
        Gate::define('admin-or-member', function ($user) {
            return $user->roles()->whereIn('name', ['admin', 'member'])->exists();
        });
        
    }
}
