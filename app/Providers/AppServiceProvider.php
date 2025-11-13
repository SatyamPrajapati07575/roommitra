<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Visit;
use App\Models\VirtualTour;
use App\Policies\VisitPolicy;
use App\Policies\VirtualTourPolicy;

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
        // Register policies
        Gate::policy(Visit::class, VisitPolicy::class);
        Gate::policy(VirtualTour::class, VirtualTourPolicy::class);
    }
}
