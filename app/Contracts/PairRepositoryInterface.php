<?php

namespace App\Contracts;

use App\Models\{Pair};

interface PairRepositoryInterface
{
    /**
     * @param Pair $pair
     * @param array $data
     * @return void
     */
    public function update(Pair $pair, array $data);
}
