<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

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
        Filament::registerNavigationGroups([
            'Rsvp & Item orders',
            'Products',
            'Events',
            'Outlet & Tables',
            'Member Management',
            'Settings',
            'User Management',
        ]);

        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Scan QR')
                    ->url('/admin/rsvps/scanqr', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-qr-code')
                    ->activeIcon('heroicon-s-qr-code')
                    ->group('Rsvp & Item orders')
                    ->sort(3),
            ]);
        });
    }
}
