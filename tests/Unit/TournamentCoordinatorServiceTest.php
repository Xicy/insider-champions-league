<?php

namespace Tests\Unit;

use App\Services\TournamentCoordinatorService;
use App\Contracts\{
    TournamentRepositoryInterface,
    TeamRepositoryInterface,
    PairRepositoryInterface,
    PredictionInterface
};
use App\Models\{Team, Pair, Tournament};
use Mockery;
use Tests\TestCase;

class TournamentCoordinatorServiceTest extends TestCase
{
    /**
     * @var TournamentCoordinatorService
     */
    protected $tournamentCoordinatorService;

    protected $tournamentRepository;
    protected $teamRepository;
    protected $pairRepository;
    protected $predictionService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock repositories and PredictionService
        /**
         * @var object
         * */
        $this->tournamentRepository = $this->getMockBuilder(TournamentRepositoryInterface::class)->getMock();
        /**
         * @var object
         * */
        $this->teamRepository = $this->getMockBuilder(TeamRepositoryInterface::class)->getMock();
        /**
         * @var object
         * */
        $this->pairRepository = $this->getMockBuilder(PairRepositoryInterface::class)->getMock();
        /**
         * @var object
         * */
        $this->predictionService = $this->getMockBuilder(PredictionInterface::class)->getMock();

        // Instantiate TournamentCoordinatorService
        $this->tournamentCoordinatorService = new TournamentCoordinatorService(
            $this->tournamentRepository,
            $this->teamRepository,
            $this->pairRepository,
            $this->predictionService
        );
    }

    /**
     * Test result method of TournamentCoordinatorService
     */
    public function testResult(): void
    {
        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $tournament->shouldReceive('toArray')->andReturn([]);

        $this->tournamentRepository->expects($this->once())->method('findById')->will($this->returnValue($tournament));
        $this->tournamentRepository->expects($this->once())->method('getCurrentWeek')->will($this->returnValue(0));
        $this->predictionService->expects($this->once())->method('predict')->will($this->returnValue(collect()));
        // depending on your specific implementation.

        // Execute result
        $result = $this->tournamentCoordinatorService->result($tournament);

        // Assertions
        $this->assertIsArray($result);
        $this->assertArrayHasKey("current_week", $result);
        $this->assertArrayHasKey("predictions", $result);
    }

    /**
     * Test playAll method of TournamentCoordinatorService
     */
    public function testPlayAll_when_pair_count_eq_0(): void
    {
        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $this->tournamentRepository->expects($this->once())->method('getCurrentWeekPairs')->will($this->returnValue(collect()));

        // Execute playAll
        $result = $this->tournamentCoordinatorService->playAll($tournament);

        // Assertion
        $this->assertTrue($result);
    }


    /**
     * Test playAll method of TournamentCoordinatorService
     */
    public function playNextWeek_when_pair(): void
    {
        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $homeTeam = (new Team())->forceFill(["id" => 1, "power" => 50, "won" => 1, "lost" => 0, "drawn" => 0]);
        $awayTeam = (new Team())->forceFill(["id" => 2, "power" => 50, "won" => 0, "lost" => 1, "drawn" => 0]);

        $pair1 = Mockery::mock(Pair::class);
        $pair2 = Mockery::mock(Pair::class);
        $pair1->shouldReceive('getAttribute')->with('homeTeam')->andReturn($homeTeam);
        $pair1->shouldReceive('getAttribute')->with('awayTeam')->andReturn($awayTeam);
        $pair2->shouldReceive('getAttribute')->with('awayTeam')->andReturn($homeTeam);
        $pair2->shouldReceive('getAttribute')->with('homeTeam')->andReturn($awayTeam);
        $pairs = collect([$pair1, $pair2]);


        $this->tournamentRepository->expects($this->atLeastOnce())->method('getCurrentWeekPairs')->will($this->returnValue($pairs));
        $this->tournamentRepository->expects($this->atLeastOnce())->method('getCurrentWeek')->will($this->returnValue(0));
        $this->predictionService->expects($this->atLeastOnce())->method('predict')->will($this->returnValue(collect()));
        $this->teamRepository->expects($this->atLeastOnce())->method('update')->will($this->returnValue(true));
        $this->pairRepository->expects($this->atLeastOnce())->method('update')->will($this->returnValue(true));

        // Execute playAll
        $result = $this->tournamentCoordinatorService->playNextWeek($tournament);

        // Assertion
        $this->assertTrue($result);
    }

    /**
     * Test reset method of TournamentCoordinatorService
     */
    public function testReset(): void
    {
        // Mock Tournament
        /**
         * @var object
         * */
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('getAttribute')->with('id')->andReturn(1);

        // TODO: Set up the mock methods for the tournament repository depending on your specific implementation.
        $this->tournamentRepository->expects($this->once())->method('resetById');

        // Execute reset
        $this->tournamentCoordinatorService->reset($tournament);

        // If no exception is thrown, the test is considered successful.

    }
}
