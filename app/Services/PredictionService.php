<?php

namespace App\Services;

use App\Contracts\PredictionInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Contracts\TournamentRepositoryInterface;
use App\Models\{Tournament};

class PredictionService implements PredictionInterface
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected TournamentRepositoryInterface $tournamentRepository
    )
    {

    }

    /**
     *
     * @param Tournament $tournament
     * @return array
     */
    public function predict(Tournament $tournament){
        $teams = $this->teamRepository->getByTournamentId($tournament->id);
        $remainingWeekCount = $this->tournamentRepository->getRemainingWeekCount($tournament->id);

        if($remainingWeekCount > 3){
            return $teams->map(fn($team) => ["team_id"=>$team->id, "chance"=>0]);
        } else if($remainingWeekCount == 0) {
            $result = $teams->map(fn ($team) => ["team_id" => $team->id, "chance" => 0]);
            $team = $result->shift();
            $team["chance"] = 100;
            $result->prepend($team);
            return $result;
        }

        $maxPoint = $teams->first()->points;
        $maxGainPoint = $remainingWeekCount * 3;

        $total = $teams->where('points', '>=', $maxPoint - $maxGainPoint)->sum('points');

        $predicts = [];
        foreach ($teams as $team) {
            $chance = 0;

            if ($team->points + $maxGainPoint >= $maxPoint) {
                $chance = floor($team->points / ($total ?: 1) * 100);
            }

            $predicts[] = [
                'team_id' => $team->id,
                "chance" => $chance
            ];
        }

        return $predicts;
    }
}
