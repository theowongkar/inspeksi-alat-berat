<?php

namespace App\Providers;

use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\User;
use App\Policies\EquipmentPolicy;
use App\Policies\InspectionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Equipment::class, EquipmentPolicy::class);
        Gate::policy(Inspection::class, InspectionPolicy::class);
    }
}
