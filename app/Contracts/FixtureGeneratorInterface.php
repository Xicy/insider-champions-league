<?php

namespace App\Contracts;

use App\Models\{Tournament,Pair};
use Illuminate\Support\Collection;

interface FixtureGeneratorInterface
{
    /**
     * @template TKey of array-key
     *
     * @param Tournament $tournament
     * @return Collection<TKey, Pair>
     */
    public function generate(Tournament $tournament): Collection;
}
