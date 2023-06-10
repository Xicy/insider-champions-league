<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TournamentController,
    SimulationController
};

Route::apiResources([
    'tournaments' => TournamentController::class
]);

Route::controller(SimulationController::class)->prefix('tournaments/{tournament}/simulation')->group(function () {
    Route::get('result', 'result');
    Route::post('play-all', 'playAll');
    Route::post('play-next-week', 'playNextWeek');
    Route::post('reset', 'reset');
});
