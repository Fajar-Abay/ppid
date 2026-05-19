<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\ComplaintResource;
use App\Filament\Resources\DocumentResource;
use App\Filament\Resources\LetterResource;
use App\Filament\Resources\LetterTemplateResource;
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\SettingResource;
use App\Filament\Resources\UserResource;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
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
            ->login(\App\Filament\Pages\Auth\CustomLogin::class)
            ->profile(\App\Filament\Pages\Auth\CustomProfile::class)
            ->colors([
                'primary' => Color::hex('#3d60a1'),   // Navy Blue (Institutional Authority)
                'danger'  => Color::hex('#9b2c2c'),
                'warning' => Color::hex('#c05621'),
                'success' => Color::hex('#2f855a'),
                'info'    => Color::hex('#2b6cb0'),
                'gray'    => Color::hex('#868e96'),
            ])
            ->font('Inter')
            ->brandName(fn () => settings('site_name', 'PPID Portal'))
            ->brandLogo(fn () => asset('images/logo-smea-text.svg'))
            ->brandLogoHeight('2.5rem')
            ->favicon(fn () => settings('favicon_url'))
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->navigationGroups([
                'Layanan PPID',
                'Publikasi & Informasi',
                'Manajemen Konten',
                'Pengaturan Sistem',
            ])
            ->resources([
                // Layanan PPID
                DocumentResource::class,
                ComplaintResource::class,
                LetterResource::class,
                \App\Filament\Resources\ContactMessageResource::class,
                // Publikasi & Informasi
                PostResource::class,
                \App\Filament\Resources\Agendas\AgendaResource::class,
                \App\Filament\Resources\Announcements\AnnouncementResource::class,
                // Manajemen Konten
                CategoryResource::class,
                BannerResource::class,
                // Pengaturan Sistem
                LetterTemplateResource::class,
                UserResource::class,
                SettingResource::class,
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                \App\Filament\Widgets\DashboardWelcomeWidget::class,
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\ComplaintStatusChart::class,
                \App\Filament\Widgets\RecentComplaintsTable::class,
                \App\Filament\Widgets\RecentMessagesTable::class,
                \App\Filament\Widgets\RecentPostsTable::class,
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ]);
    }
}
