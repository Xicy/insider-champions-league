<?php

namespace App\Contracts;

use App\Models\Fixture;
use App\Models\{Team, Tournament};
use Illuminate\Database\Eloquent\Collection;

interface TournamentRepositoryInterface
{
    /**
     * @return Collection<Tournament>
     */
    public function all(): Collection;

    /**
     * @param array<Team> $teams
     * @return Tournament
     */
    public function create(array $teams): Tournament;

    /**
     * @param int $id
     * @return Tournament
     */
    public function findById(int $id): Tournament;
}
