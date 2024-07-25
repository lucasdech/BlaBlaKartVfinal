<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Providers\Filament\Widgets\AccountWidget;
use App\Providers\Filament\Widgets\StatsOverviewWidget as WidgetsStatsOverviewWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Providers/Filament/Widgets'), for: 'App\\Providers\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class, 
                FilamentInfoWidget::class,
                WidgetsStatsOverviewWidget::class,
                UserOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->userMenuItems([
            //     'profile' => Pages\Profile::class,
            // ])
            // ->profile(Pages\Profile::class)
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->brandName('Admin Panel')
            ->maxContentWidth('full')
            ->sidebarCollapsibleOnDesktop()
            ->tenant(null)
            ->tenantMenuItems([])
            ->renderHook(
                'panels::body.end',
                fn () => view('filament.custom.footer'),
            )
            ->plugins([]);
    }
}
