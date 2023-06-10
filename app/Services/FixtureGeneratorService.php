<?php

namespace App\Services;

use App\Contracts\FixtureGeneratorInterface;
use App\Models\{Tournament, Team, Pair};
use Illuminate\Support\Collection;

class FixtureGeneratorService implements FixtureGeneratorInterface
{
    /**
     * @template TKey of array-key
     *
     * @param Tournament $tournament
     * @return Collection<TKey, Pair>
     */
    public function generate(Tournament $tournament) : Collection
    {
        $teams = $tournament->teams->shuffle();
        $this->prepareTeamCollection($teams);

        $teamCount = $teams->count();
        $halfTeamCount = $teamCount / 2;

        $weeks = $this->getTotalWeek($teamCount);

        $pairs = new Collection();
        for ($week = 1; $week <= $weeks; $week++) {
            foreach ($teams as $index => $team) {
                if ($index >= $halfTeamCount) {
                    break;
                }
                $team1 = $team;
                $team2 = $teams->get($teamCount - $index - 1);

                $pairAttributes = $week % 2 === 1 ?
                    ['home_team_id' => $team1['id'], 'away_team_id' => $team2['id'], 'week' => $week] :
                    ['home_team_id' => $team2['id'], 'away_team_id' => $team1['id'], 'week' => $week];

                if($pairAttributes['home_team_id'] == null ||  $pairAttributes['away_team_id'] == null){
                    continue;
                }

                $pairs->push($this->createPair($pairAttributes));
            }
            $this->rotate($teams);
        }
        return $pairs;
    }


    /**
     * @param Collection $teams
     * @return void
     */
    private function rotate(Collection $teams): void
    {
        [$first, $second] = $teams->shift(2);
        $teams->prepend($first);
        $teams->push($second);
    }

    /**
     * @param int $teamsCount
     * @return int
     */
    private function getTotalWeek(int $teamsCount): int
    {
        return ($teamsCount % 2 === 0 ? $teamsCount - 1 : $teamsCount) * 2;
    }

    /**
     * @param Collection $teams
     * @return void
     */
    private function prepareTeamCollection(Collection $teams): void
    {
        if ($teams->count() % 2 === 1) {
            $teams->push(new Team());
        }
    }

    /**
     * @param array $attributes
     * @return Pair
     */
    private function createPair(array $attributes): Pair
    {
        return new Pair($attributes);
    }
}
