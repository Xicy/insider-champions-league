<?php

namespace App\Services;

use App\Contracts\{
    TournamentCoordinatorInterface,
    TournamentRepositoryInterface,
    TeamRepositoryInterface,
    PairRepositoryInterface
};

use App\Models\{Tournament, Pair};

class TournamentCoordinatorService implements TournamentCoordinatorInterface
{

    public function __construct(
        protected TournamentRepositoryInterface $tournamentRepository,
        protected TeamRepositoryInterface $teamRepository,
        protected PairRepositoryInterface $pairRepository
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
        return [...$tournament->toArray(), "current_week" => $current_week];
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
        if($pairs->count() == 0)
        {
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
            if (rand(0, 100) <= 55) {
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
        if (rand(0, 100) <= $power) {
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

        // TODO: refactor more readable
        if ($homeScore > $awayScore) {
            $pair->homeTeam->won++;
            $pair->homeTeam->goals_for += $homeScore;
            $pair->homeTeam->goals_against += $awayScore;
            $pair->homeTeam->points += 3;

            $pair->awayTeam->lost++;
            $pair->awayTeam->goals_for += $awayScore;
            $pair->awayTeam->goals_against += $homeScore;
        } elseif ($homeScore < $awayScore) {
            $pair->awayTeam->won++;
            $pair->awayTeam->goals_for += $homeScore;
            $pair->awayTeam->goals_against += $awayScore;
            $pair->awayTeam->points += 3;

            $pair->homeTeam->lost++;
            $pair->homeTeam->goals_for += $awayScore;
            $pair->homeTeam->goals_against += $homeScore;
        } else {
            $pair->homeTeam->drawn++;
            $pair->homeTeam->goals_for += $homeScore;
            $pair->homeTeam->goals_against += $awayScore;
            $pair->homeTeam->points++;

            $pair->awayTeam->drawn++;
            $pair->awayTeam->goals_for += $awayScore;
            $pair->awayTeam->goals_against += $homeScore;
            $pair->awayTeam->points++;
        }

        $this->teamRepository->update($pair->homeTeam, $pair->homeTeam->toArray());
        $this->teamRepository->update($pair->awayTeam, $pair->awayTeam->toArray());
    }
}
