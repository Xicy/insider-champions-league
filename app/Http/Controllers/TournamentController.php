<?php

namespace App\Http\Controllers;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Validate
        $data = $request->validate([
            "teams.*.name" => "required",
            "teams.*.power" => "required, numeric"
        ]);
        return $this->tournamentRepository->create($data["teams"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        return $this->tournamentRepository->findById($tournament->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        //
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
