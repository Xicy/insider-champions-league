<?php

namespace App\Http\Controllers;

use App\Models\{Tournament};
use App\Contracts\TournamentCoordinatorInterface;

class SimulationController extends Controller
{
    /**
     * @param TournamentCoordinatorInterface $tournamentCoordinator
     */
    public function __construct(
        protected TournamentCoordinatorInterface $tournamentCoordinator
    ) {
    }

    /**
     *
     * @param Tournament $tournament
     * @return \Illuminate\Http\JsonResponse
     */
    public function result(Tournament $tournament){
        $result = $this->tournamentCoordinator->result($tournament);
        return response()->json($result);
    }

    /**
     *
     * @param Tournament $tournament
     * @return \Illuminate\Http\JsonResponse
     */
    public function playAll(Tournament $tournament)
    {
        $this->tournamentCoordinator->playAll($tournament);
        return response()->json();
    }

    /**
     *
     * @param Tournament $tournament
     * @return \Illuminate\Http\JsonResponse
     */
    public function playNextWeek(Tournament $tournament)
    {
        $this->tournamentCoordinator->playNextWeek($tournament);
        return response()->json();
    }

    /**
     *
     * @param Tournament $tournament
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Tournament $tournament)
    {
        $this->tournamentCoordinator->reset($tournament);
        return response()->json();
    }
}
