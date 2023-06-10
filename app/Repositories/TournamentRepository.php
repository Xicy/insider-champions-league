<?php

namespace App\Repositories;

use App\Contracts\{TournamentRepositoryInterface, FixtureGeneratorInterface};
use App\Models\{Team, Tournament};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class TournamentRepository implements TournamentRepositoryInterface
{
    /**
     * @param Tournament $model
     * @param FixtureGeneratorInterface $fixtureGenerator
     */
    public function __construct(
        protected Tournament $model,
        protected FixtureGeneratorInterface $fixtureGenerator
    ) {
    }

    /**
     * @return Collection<Tournament>
     */
    public function all(): Collection
    {
        return $this->model->newQuery()->orderBy('id', 'desc')->get();
    }

    /**
     * @param array<Team> $teams
     * @return Tournament
     */
    public function create(array $teams): Tournament
    {
        $tournament = $this->model->create();
        $tournament->teams()->createMany($teams);
        $pairs = $this->fixtureGenerator->generate($tournament);
        $tournament->pairs()->createMany($pairs->toArray());
        $tournament->push();
        return $tournament;
    }

    /**
     * @param int $id
     * @return Tournament
     */
    public function findById(int $id): Tournament
    {
        $tournament = $this->model->newQuery()
            ->with([
                'pairs',
                'teams' => fn ($q) => $q->orderBy('won', 'desc')->orderBy('drawn', 'desc')->orderBy('lost', 'asc')
            ])
            ->find($id);
        $tournament->fixtures = $tournament->pairs->groupBy('week')->values();
        return $tournament;
    }

    /**
     * @param int $id
     * @return void
     */
    public function resetById(int $id)
    {
        $tournament = $this->model->find($id);
        $teams = $tournament->teams()->get(['name', 'power']);
        $tournament->teams()->delete();
        $tournament->pairs()->delete();

        $tournament->teams()->createMany($teams->toArray());
        $pairs = $this->fixtureGenerator->generate($tournament);
        $tournament->pairs()->createMany($pairs->toArray());
        $tournament->push();
    }

    /**
     * @param int $id
     * @return int
     */
    public function getCurrentWeek(int $id)
    {
        $tournament = $this->findById($id);
        $pair = $tournament->pairs()->orderBy('week')->where('played', false)->first();
        return $pair?->week ?? -1;
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getCurrentWeekPairs(int $id)
    {
        $week = $this->getCurrentWeek($id);
        if ($week == -1) {
            return new SupportCollection();
        }
        $tournament = $this->findById($id);
        return $tournament->pairs()->with('homeTeam', 'awayTeam')->where('week', $week)->get();
    }

    /**
     * @param int $id
     * @return int
     */
    public function getRemainingWeekCount(int $id)
    {
        $currentWeek = $this->getCurrentWeek($id);
        if ($currentWeek == -1) {
            $currentWeek = 0;
        }
        $tournament = $this->findById($id);
        $pair = $tournament->pairs()->orderBy('week', 'desc')->where('played', false)->first();
        $lastWeek = $pair?->week ?? 0;
        return ($lastWeek - $currentWeek);
    }
}
