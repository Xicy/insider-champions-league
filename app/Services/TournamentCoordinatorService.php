<?php

namespace App\Services;

use App\Contracts\{
    TournamentCoordinatorInterface,
    TournamentRepositoryInterface,
    TeamRepositoryInterface,
    PairRepositoryInterface,
    PredictionInterface
};

use App\Models\{Tournament, Pair, Team};

class TournamentCoordinatorService implements TournamentCoordinatorInterface
{

    public function __construct(
        protected TournamentRepositoryInterface $tournamentRepository,
        protected TeamRepositoryInterface $teamRepository,
        protected PairRepositoryInterface $pairRepository,
        protected PredictionInterface $predictionService
    ) {
    }

    /**
     *
     * @param Tournament $tournament
     * @return array
     */
    public function result(Tournament $tournament)
    {
        $tournament = $this->tournamentRepository->findById($tournament->id);
        $current_week = $this->tournamentRepository->getCurrentWeek($tournament->id);
        $predictions = $this->predictionService->predict($tournament);
        return [...$tournament->toArray(), "current_week" => $current_week, "predictions" => $predictions];
    }

    /**
     *
     * @param Tournament $tournament
     * @return boolean
     */
    public function playAll(Tournament $tournament)
    {
        while ($this->playNextWeek($tournament)) {
        }
        return true;
    }

    /**
     *
     * @param Tournament $tournament
     * @return boolean
     */
    public function playNextWeek(Tournament $tournament)
    {
        $pairs = $this->tournamentRepository->getCurrentWeekPairs($tournament->id);
        if ($pairs->count() == 0) {
            return false;
        }

        foreach ($pairs as $pair) {
            $result = $this->play($pair);
            $this->pairRepository->update($pair, $result);
            $this->updateResult($pair, $result);
        }
        return true;
    }

    /**
     *
     * @param Tournament $tournament
     * @return void
     */
    public function reset(Tournament $tournament)
    {
        $this->tournamentRepository->resetById($tournament->id);
    }


    /**
     *
     * @param Pair $pair
     * @return array
     */
    private function play(Pair $pair)
    {
        $home_team_score = 0;
        $away_team_score = 0;
        for ($i = 15; $i <= 90; $i += 15) {
            if (rand(0, 100) <= 50) {
                $home_team_score += $this->score($pair->homeTeam->power);
            } else {
                $away_team_score += $this->score($pair->awayTeam->power);
            }
        }

        return [
            "home_team_score" => $home_team_score,
            "away_team_score" => $away_team_score,
            "played" => true
        ];
    }

    /**
     *
     * @param int $power
     * @return int
     */
    private function score(int $power): int
    {
        if (rand(0, 110) <= $power) {
            return 1;
        }
        return 0;
    }

    /**
     *
     * @param Pair $pair
     * @param array $result
     * @return void
     */
    private function updateResult(Pair $pair, array $result)
    {
        $homeScore = $result['home_team_score'];
        $awayScore = $result['away_team_score'];

        if ($homeScore > $awayScore) {
            $this->won($pair->homeTeam, $homeScore, $awayScore);
            $this->lost($pair->awayTeam, $awayScore, $homeScore);
        } elseif ($homeScore < $awayScore) {
            $this->won($pair->awayTeam, $awayScore, $homeScore);
            $this->lost($pair->homeTeam, $homeScore, $awayScore);
        } else {
            $this->drawn($pair->homeTeam, $homeScore, $awayScore);
            $this->drawn($pair->awayTeam, $awayScore, $homeScore);
        }

        $this->teamRepository->update($pair->homeTeam, $pair->homeTeam->toArray());
        $this->teamRepository->update($pair->awayTeam, $pair->awayTeam->toArray());
    }


    /**
     * @param Team $team
     * @param int $goalsFor
     * @param int $goalsAgainst
     * @return void
     */
    private function won(Team $team, int $goalsFor, int $goalsAgainst): void
    {
        $team->won++;
        $team->points += 3;

        $team->goals_for += $goalsFor;
        $team->goals_against += $goalsAgainst;
    }

    /**
     * @param Team $team
     * @param int $goalsFor
     * @param int $goalsAgainst
     * @return void
     */
    private function drawn(Team $team, int $goalsFor, int $goalsAgainst): void
    {
        $team->drawn++;
        $team->points++;

        $team->goals_for += $goalsFor;
        $team->goals_against += $goalsAgainst;
    }

    /**
     * @param Team $team
     * @param int $goalsFor
     * @param int $goalsAgainst
     * @return void
     */
    private function lost(Team $team, int $goalsFor, int $goalsAgainst): void
    {
        $team->lost++;

        $team->goals_for += $goalsFor;
        $team->goals_against += $goalsAgainst;
    }
}
