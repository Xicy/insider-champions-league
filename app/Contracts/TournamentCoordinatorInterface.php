<?php

namespace App\Contracts;

use App\Models\{Tournament};

interface TournamentCoordinatorInterface
{
    /**
     *
     * @param Tournament $tournament
     * @return array
     */
    public function result(Tournament $tournament);

    /**
     *
     * @param Tournament $tournament
     * @return boolean
     */
    public function playAll(Tournament $tournament);

    /**
     *
     * @param Tournament $tournament
     * @return boolean
     */
    public function playNextWeek(Tournament $tournament);

    /**
     *
     * @param Tournament $tournament
     * @return void
     */
    public function reset(Tournament $tournament);
}
