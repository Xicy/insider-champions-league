<?php

namespace App\Contracts;

use App\Models\{Tournament};

interface PredictionInterface
{
    /**
     *
     * @param Tournament $tournament
     * @return array
     */
    public function predict(Tournament $tournament);
}
