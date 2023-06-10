<?php

namespace App\Repositories;

use App\Contracts\{PairRepositoryInterface};
use App\Models\{Pair};
use Illuminate\Support\Collection;

class PairRepository implements PairRepositoryInterface
{
    /**
     * @param Pair $model
     */
    public function __construct(
        protected Pair $model,
    ) {
    }

    /**
     * @param Pair $pair
     * @param array $data
     * @return void
     */
    public function update(Pair $pair, array $data)
    {
        $this->model->find($pair->id)->update($data);
    }

    /**
     * @param int $id
     * @return Collection<Pair>
     */
    public function getByTournamentId(int $id): Collection
    {
        return $this->model->where('tournament_id', $id)->get();
    }
}
