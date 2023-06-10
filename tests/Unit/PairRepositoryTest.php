<?php

namespace Tests\Unit\Repositories;

use App\Repositories\PairRepository;
use App\Models\Pair;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class PairRepositoryTest extends TestCase
{
    /**
     * Test update method of PairRepository
     */
    public function testUpdate(): void
    {
        // New data for update
        $data = [
            'home_team_score' => 2,
            'away_team_score' => 1
        ];

        $pair = Mockery::mock(Pair::class);
        $pair->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $pair->shouldReceive('getAttribute')->with('home_team_score')->andReturn(0);
        $pair->shouldReceive('getAttribute')->with('away_team_score')->andReturn(0);
        $pair->shouldReceive('find')->with($pair->id)->andReturn($pair);
        $pair->shouldReceive('update')->once()->with($data);

        // Instantiate PairRepository
        $pairRepository = new PairRepository($pair);

        // Execute update
        $pairRepository->update($pair, $data);

        // Assertions
    }

    /**
     * Test getByTournamentId method of PairRepository
     */
    public function testGetByTournamentId(): void
    {
        // Prepare data
        $expectedTournamentId = 1;
        $result = collect();
        $pair = Mockery::mock(Pair::class);
        $pair->shouldReceive('where')->with('tournament_id', $expectedTournamentId)->andReturnSelf();
        $pair->shouldReceive('get')->once()->andReturn($result);


        // Instantiate PairRepository
        $pairRepository = new PairRepository($pair);

        // Execute getByTournamentId
        $pairs = $pairRepository->getByTournamentId($expectedTournamentId);

        // Assertions
        $this->assertInstanceOf(Collection::class, $pairs);
        $this->assertEquals($result, $pairs);
    }
}
