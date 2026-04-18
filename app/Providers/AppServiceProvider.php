<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;

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
        Gate::policy(Role::class, RolePolicy::class);

        \BezhanSalleh\LanguageSwitch\LanguageSwitch::configureUsing(function (\BezhanSalleh\LanguageSwitch\LanguageSwitch $switch) {
            $switch->locales(['ar', 'en']);
        });

        \App\Models\Booking::observe(\App\Observers\BookingObserver::class);
        \App\Models\BookinMonthly::observe(\App\Observers\BookinMonthlyObserver::class);
        \App\Models\AppNotification::observe(\App\Observers\AppNotificationObserver::class);
    }
}
