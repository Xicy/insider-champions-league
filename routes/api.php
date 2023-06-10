<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TournamentController
};

Route::apiResources([
    'tournaments' => TournamentController::class
]);
