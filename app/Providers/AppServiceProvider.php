<?php

namespace App\Providers;

use App\Contracts\{TournamentRepositoryInterface, FixtureGeneratorInterface};
use App\Repositories\{TournamentRepository};
use App\Services\{FixtureGeneratorService};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $toBind = [
            TournamentRepositoryInterface::class => TournamentRepository::class,
            FixtureGeneratorInterface::class => FixtureGeneratorService::class
        ];

        foreach ($toBind as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
