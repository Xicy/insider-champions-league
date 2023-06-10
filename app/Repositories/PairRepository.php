<?php

namespace App\Repositories;

use App\Contracts\{PairRepositoryInterface};
use App\Models\{Pair};

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

}
