<?php

namespace App\Providers;

use App\Contracts\{TournamentRepositoryInterface};
use App\Repositories\{TournamentRepository};
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
