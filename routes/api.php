<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FixtureController,
    TeamController
};

Route::resource('fixtures', FixtureController::class);
Route::resource('teams', TeamController::class);
