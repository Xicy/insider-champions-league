<?php

namespace Tests\Unit;

use App\Repositories\TeamRepository;
use App\Models\Team;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class TeamRepositoryTest extends TestCase
{
    /**
     * Test update method of TeamRepository
     */
    public function testUpdate(): void
    {
        // New data for update
        $data = [
            'won' => 2,
            'lost' => 1
        ];

        $team = Mockery::mock(Team::class);
        $team->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $team->shouldReceive('getAttribute')->with('won')->andReturn(0);
        $team->shouldReceive('getAttribute')->with('lost')->andReturn(0);
        $team->shouldReceive('find')->with($team->id)->andReturn($team);
        $team->shouldReceive('update')->once()->with($data);

        // Instantiate TeamRepository
        $teamRepository = new TeamRepository($team);

        // Execute update
        $teamRepository->update($team, $data);

        // Assertions
    }

    /**
     * Test getByTournamentId method of TeamRepository
     */
    public function testGetByTournamentId(): void
    {
        // Prepare data
        $expectedTournamentId = 1;
        $result = collect();
        $team = Mockery::mock(Team::class);
        $team->shouldReceive('where')->with('tournament_id', $expectedTournamentId)->andReturnSelf();
        $team->shouldReceive('orderBy')->with('points', 'desc')->andReturnSelf();
        $team->shouldReceive('get')->once()->andReturn($result);


        // Instantiate TeamRepository
        $teamRepository = new TeamRepository($team);

        // Execute getByTournamentId
        $teams = $teamRepository->getByTournamentId($expectedTournamentId);

        // Assertions
        $this->assertInstanceOf(Collection::class, $teams);
        $this->assertEquals($result, $teams);
    }
}
