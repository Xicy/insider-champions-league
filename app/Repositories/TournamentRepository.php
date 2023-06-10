<?php

namespace App\Repositories;

use App\Contracts\TournamentInterface;
use App\Models\{Team, Tournament};
use Illuminate\Database\Eloquent\Collection;

class TournamentRepository implements TournamentInterface
{
    /**
     * @param Fixture $model
     */
    public function __construct(protected Tournament $model)
    {
    }

    /**
     * @return Collection<Tournament>
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array<Team> $teams
     * @return Tournament
     */
    public function create(Team ...$teams): Tournament
    {
        return $this->model->create(compact("teams"));
    }

    /**
     * @param int $id
     * @return Tournament
     */
    public function findById(int $id): Tournament{
        return $this->model->find($id);
    }
}
