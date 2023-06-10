<?php

namespace App\Repositories;

use App\Contracts\{TeamRepositoryInterface};
use App\Models\{Team};
use Illuminate\Support\Collection;

class TeamRepository implements TeamRepositoryInterface
{
    /**
     * @param Team $model
     */
    public function __construct(
        protected Team $model,
    ) {
    }

    /**
     * @param Team $team
     * @param array $data
     * @return void
     */
    public function update(Team $team, array $data)
    {
        $this->model->find($team->id)->update($data);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getByTournamentId(int $id): Collection
    {
        return $this->model->where('tournament_id', $id)->orderBy('points', 'desc')->get();
    }
}
