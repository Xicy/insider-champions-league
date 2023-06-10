<?php

namespace App\Contracts;

use App\Models\{Team};

interface TeamRepositoryInterface
{
    /**
     * @param Team $team
     * @param array $data
     * @return void
     */
    public function update(Team $team, array $data);
}
