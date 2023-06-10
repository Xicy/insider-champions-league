<?php

namespace App\Repositories;

use App\Contracts\{TeamRepositoryInterface};
use App\Models\{Team};

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

}
