<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentStoreRequest;
use App\Contracts\{TournamentInterface};
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{

    public function __construct(
        protected TournamentInterface $tournamentRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->tournamentRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TournamentStoreRequest $request)
    {
        $data = $request->validated();
        return $this->tournamentRepository->create($data["teams"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        // TODO: Use service
        $tournament = $this->tournamentRepository->findById($tournament->id);
        $response = [
            "teams" => $tournament->teams,
            "weeks" => $tournament->fixtures
        ];
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        //
    }
}
