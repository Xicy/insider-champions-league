<?php

namespace Tests\Unit;

use App\Services\PredictionService;
use App\Contracts\{
    TournamentRepositoryInterface,
    TeamRepositoryInterface,
    PairRepositoryInterface
};
use App\Models\{Tournament, Team, Pair};
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class PredictionServiceTest extends TestCase
{
    /**
     * Test predict function of PredictionService
     */
    public function testPredict_when_calculate_normally(): void
    {
        // Prepare data
        $teams = collect(range(1, 4))->map(function ($i) {
            $team = new Team();
            $team->forceFill(["id" => $i]);
            $team->points = $i * 3;
            return $team;
        });

        // Mock repositories
        /**
         * @var object
         * */
        $teamRepository = $this->getMockBuilder(TeamRepositoryInterface::class)->getMock();
        $teamRepository->method('getByTournamentId')->willReturn($teams);
        /**
         * @var object
         * */
        $pairRepository = $this->getMockBuilder(PairRepositoryInterface::class)->getMock();
        $pairRepository->method('getByTournamentId')->willReturn(new Collection());
        /**
         * @var object
         * */
        $tournamentRepository = $this->getMockBuilder(TournamentRepositoryInterface::class)->getMock();
        $tournamentRepository->method('getRemainingWeekCount')->willReturn(2);

        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);

        // Instantiate PredictionService
        $predictionService = new PredictionService($teamRepository, $pairRepository, $tournamentRepository);

        // Execute predict
        $result = $predictionService->predict($tournament);

        // Assert result is an collection and has same number of elements as teams
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount($teams->count(), $result);

        // Test the expected values for each team
        foreach ($result as $teamPrediction) {
            $team = $teams->firstWhere('id', $teamPrediction["team_id"]);
            $this->assertNotNull($team);
            $this->assertArrayHasKey("chance", $teamPrediction);
        }
    }

    /**
     * Test predict function of PredictionService
     */
    public function testPredict_when_tournament_finished(): void
    {
        // Prepare data
        $teams = collect(range(1, 4))->map(function ($i) {
            $team = new Team();
            $team->forceFill(["id" => $i]);
            $team->points = $i * 3;
            return $team;
        });

        // Mock repositories
        /**
         * @var object
         * */
        $teamRepository = $this->getMockBuilder(TeamRepositoryInterface::class)->getMock();
        $teamRepository->method('getByTournamentId')->willReturn($teams);
        /**
         * @var object
         * */
        $pairRepository = $this->getMockBuilder(PairRepositoryInterface::class)->getMock();
        $pairRepository->method('getByTournamentId')->willReturn(new Collection());
        /**
         * @var object
         * */
        $tournamentRepository = $this->getMockBuilder(TournamentRepositoryInterface::class)->getMock();
        $tournamentRepository->method('getRemainingWeekCount')->willReturn(0);

        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);

        // Instantiate PredictionService
        $predictionService = new PredictionService($teamRepository, $pairRepository, $tournamentRepository);

        // Execute predict
        /**
         * @var Collection
         * */
        $result = $predictionService->predict($tournament);

        // Assert result is an collection and has same number of elements as teams
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount($teams->count(), $result);

        // Test the expected values for each team
        foreach ($result as $teamPrediction) {
            $team = $teams->firstWhere('id', $teamPrediction["team_id"]);
            $this->assertNotNull($team);
            $this->assertArrayHasKey("chance", $teamPrediction);
        }

        $this->assertEquals(100, $result->get(0)["chance"]);
        $this->assertEquals(0, $result->get(1)["chance"]);
        $this->assertEquals(0, $result->get(2)["chance"]);
        $this->assertEquals(0, $result->get(3)["chance"]);
    }


    /**
     * Test predict function of PredictionService
     */
    public function testPredict_when_has_more_than_3_week(): void
    {
        // Prepare data
        $teams = collect(range(1, 4))->map(function ($i) {
            $team = new Team();
            $team->forceFill(["id" => $i]);
            $team->points = $i * 3;
            return $team;
        });

        // Mock repositories
        /**
         * @var object
         * */
        $teamRepository = $this->getMockBuilder(TeamRepositoryInterface::class)->getMock();
        $teamRepository->method('getByTournamentId')->willReturn($teams);
        /**
         * @var object
         * */
        $pairRepository = $this->getMockBuilder(PairRepositoryInterface::class)->getMock();
        $pairRepository->method('getByTournamentId')->willReturn(new Collection());
        /**
         * @var object
         * */
        $tournamentRepository = $this->getMockBuilder(TournamentRepositoryInterface::class)->getMock();
        $tournamentRepository->method('getRemainingWeekCount')->willReturn(4);

        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);

        // Instantiate PredictionService
        $predictionService = new PredictionService($teamRepository, $pairRepository, $tournamentRepository);

        // Execute predict
        /**
         * @var Collection
         * */
        $result = $predictionService->predict($tournament);

        // Assert result is an collection and has same number of elements as teams
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount($teams->count(), $result);

        // Test the expected values for each team
        foreach ($result as $teamPrediction) {
            $team = $teams->firstWhere('id', $teamPrediction["team_id"]);
            $this->assertNotNull($team);
            $this->assertArrayHasKey("chance", $teamPrediction);
            $this->assertEquals(0, $teamPrediction["chance"]);
        }
    }
}
