<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FixtureController,
    TeamController,
    TournamentController
};

Route::resource('fixtures', FixtureController::class);
Route::resource('teams', TeamController::class);
Route::resource('tournament', TournamentController::class);
