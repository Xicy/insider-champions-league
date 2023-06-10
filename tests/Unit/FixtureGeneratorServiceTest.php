<?php

namespace Tests\Unit;

use App\Services\FixtureGeneratorService;
use App\Models\Tournament;
use App\Models\Team;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class FixtureGeneratorServiceTest extends TestCase
{
    /**
     * Test generate function of FixtureGeneratorService
     */
    public function testGenerate(): void
    {
        // Prepare data
        $teams = collect(range(1, 4))->map(function ($i){
            $team = new Team();
            return $team->forceFill(["id" => $i]);
        });

        // Mock Tournament
        /**
         * @var Tournament
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('teams')->andReturn($teams);

        // Instantiate FixtureGeneratorService
        $fixtureGeneratorService = new FixtureGeneratorService();

        // Execute generate
        $result = $fixtureGeneratorService->generate($tournament);

        // Assert result is a Collection
        $this->assertInstanceOf(Collection::class, $result);

        // Test the number of generated pairs is as per expectation
        $totalMatches = $teams->count() * ($teams->count() - 1);
        $this->assertCount($totalMatches, $result);
    }
}
