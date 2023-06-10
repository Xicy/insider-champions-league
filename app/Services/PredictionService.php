<?php

namespace App\Services;

use App\Models\{Tournament};
use App\Contracts\{
    PredictionInterface,
    TournamentRepositoryInterface,
    TeamRepositoryInterface,
    PairRepositoryInterface
};

class PredictionService implements PredictionInterface
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected PairRepositoryInterface $pairRepository,
        protected TournamentRepositoryInterface $tournamentRepository
    ) {
    }

    /**
     *
     * @param Tournament $tournament
     * @return array
     */
    public function predict(Tournament $tournament)
    {
        $teams = $this->teamRepository->getByTournamentId($tournament->id);
        $remainingWeekCount = $this->tournamentRepository->getRemainingWeekCount($tournament->id);

        if ($remainingWeekCount > 3) {
            return $teams->map(fn ($team) => ["team_id" => $team->id, "chance" => 0]);
        }

        if ($remainingWeekCount == 0) {
            $result = $teams->map(fn ($team) => ["team_id" => $team->id, "chance" => 0]);
            $team = $result->shift();
            $team["chance"] = 100;
            $result->prepend($team);
            return $result;
        }

        $pairs = $this->pairRepository->getByTournamentId($tournament->id);
        $maxPoint = $teams->first()->points;
        $maxGainPoint = $remainingWeekCount * 3;

        $total = $teams->where('points', '>=', $maxPoint - $maxGainPoint)->sum('points') ?: 1;
        $teamsClone = collect($teams->toArray());

        foreach ($teams as $team) {
            $playable = $pairs->filter(fn ($pair) => !$pair->played && ($pair->home_team_id == $team->id || $pair->away_team_id == $team->id))->count();
            $gainablePoint = $playable * 3;
            $maxGain = $team->points + $gainablePoint;

            if ($teamsClone->where("points", ">=", $maxGain)->where('id', "!=", $team->id)->count() > 0) {
                $team->points = 0;
            } else {
                $team->points = $maxGain;
            }
        }

        return $teams->map(fn ($item) => ["team_id" => $item->id, "chance" => min(floor($item->points / $total * 100), 100)]);
    }
}
