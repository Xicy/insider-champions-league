<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentStoreRequest;
use App\Contracts\{TournamentRepositoryInterface, FixtureGeneratorInterface};
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{

    public function __construct(
        protected TournamentRepositoryInterface $tournamentRepository,
        protected FixtureGeneratorInterface $fixtureGeneratorInterface
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
        // TODO: Move to service
        $tournament = $this->tournamentRepository->findById($tournament->id);
        $tournament->fixtures = $this->fixtureGeneratorInterface->generate($tournament)->groupBy('week')->values();
        //$tournament->fixtures = $tournament->fixtures->groupBy('week');
        return $tournament;
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
