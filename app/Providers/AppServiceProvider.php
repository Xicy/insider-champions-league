<?php

namespace App\Providers;

use App\Contracts\{
    TournamentRepositoryInterface,
    TeamRepositoryInterface,
    PairRepositoryInterface,
    FixtureGeneratorInterface,
    TournamentCoordinatorInterface
};
use App\Repositories\{
    TournamentRepository,
    TeamRepository,
    PairRepository
};
use App\Services\{
    FixtureGeneratorService,
    TournamentCoordinatorService
};
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
            PairRepositoryInterface::class => PairRepository::class,
            TeamRepositoryInterface::class => TeamRepository::class,
            FixtureGeneratorInterface::class => FixtureGeneratorService::class,
            TournamentCoordinatorInterface::class => TournamentCoordinatorService::class
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
