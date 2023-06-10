<?php

namespace App\Contracts;

use App\Models\{Pair};
use Illuminate\Support\Collection;

interface PairRepositoryInterface
{
    /**
     * @param Pair $pair
     * @param array $data
     * @return void
     */
    public function update(Pair $pair, array $data);

    /**
     * @param int $id
     * @return Collection<Pair>
     */
    public function getByTournamentId(int $id): Collection;
}
