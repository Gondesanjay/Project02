<?php

namespace App\Providers;

use App\Models\Ujian;
use App\Models\MataPelajaran;
use App\Models\TipsBelajar;
use App\Policies\UjianPolicy;
use App\Policies\MataPelajaranPolicy;
use App\Policies\TipsBelajarPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     */
    protected $policies = [
        Ujian::class => UjianPolicy::class,
        MataPelajaran::class => MataPelajaranPolicy::class,
        TipsBelajar::class => TipsBelajarPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
