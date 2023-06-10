<?php

namespace App\Contracts;

use App\Models\{Team};
use Illuminate\Support\Collection;

interface TeamRepositoryInterface
{
    /**
     * @param Team $team
     * @param array $data
     * @return void
     */
    public function update(Team $team, array $data);

    /**
     * @param int $id
     * @return Collection<Team>
     */
    public function getByTournamentId(int $id): Collection;
}
