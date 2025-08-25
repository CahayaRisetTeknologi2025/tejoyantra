<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Profile;
use App\Filament\Resources\CustomNavigation;
use App\Filament\Widgets\IKRStatusChart;
use App\Filament\Widgets\IKRStatusWorkChart;
use App\Filament\Widgets\LatestInstallationTable;
use App\Filament\Widgets\StatsIKROverview;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->navigationGroups([
                'Master Data'
            ])
            ->unsavedChangesAlerts()
            ->collapsibleNavigationGroups(false)
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('TEJOYANTRA')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->userMenuItems([
                'profile' => fn (Action $action) => $action->label('Ubah Profil')
            ])
            ->profile()
            ->font('Inter')
            ->maxContentWidth('full')
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
//                AccountWidget::class,
                IKRStatusWorkChart::class,
                IKRStatusChart::class,
                StatsIKROverview::class,
                LatestInstallationTable::class,
//                FilamentInfoWidget::class,
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
            ]);
    }
}
