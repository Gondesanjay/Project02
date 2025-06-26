<?php

namespace App\Providers\Filament;

// --- Import SEMUA Resource dan Widget Anda ---
use App\Filament\Resources\MataPelajaranResource;
use App\Filament\Resources\TipsBelajarResource;
use App\Filament\Resources\UjianResource;
use App\Filament\Widgets\UjianMendatangWidget;
use App\Filament\Widgets\UjianPerBulanChart;
use App\Filament\Widgets\UjianStatsOverview;
use App\Filament\Widgets\NotifikasiTerbaru;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
            ->profile()
            ->colors(['primary' => Color::Amber])
            ->pages([
                Pages\Dashboard::class,
            ])
            // --- Mendaftarkan semua resource secara manual ---
            ->resources([
                MataPelajaranResource::class,
                UjianResource::class,
                TipsBelajarResource::class,
            ])
            // --- Mendaftarkan semua widget secara manual ---
            ->widgets([
                UjianStatsOverview::class,
                UjianPerBulanChart::class,
                UjianMendatangWidget::class,
                NotifikasiTerbaru::class,
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
