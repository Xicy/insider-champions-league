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

    /**
     * @param int $id
     * @return void
     */
    public function resetById(int $id);

    /**
     * @param int $id
     * @return int
     */
    public function getCurrentWeek(int $id);

    /**
     * @param int $id
     * @return int
     */
    public function getRemainingWeekCount(int $id);

    /**
     * @param int $id
     * @return Collection
     */
    public function getCurrentWeekPairs(int $id);
}
