<?php

namespace Tests\Unit;

use App\Contracts\FixtureGeneratorInterface;
use App\Models\Team;
use App\Models\Pair;
use App\Models\Tournament;
use App\Repositories\TournamentRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;
use Mockery;
use Tests\TestCase;

class TournamentRepositoryTest extends TestCase
{
    /**
     * Test all method of TournamentRepository
     */
    public function testAll(): void
    {
        // Instantiate TournamentRepository
        /**
         * @var object
         */
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->once()->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('id','desc')->andReturnSelf();
        $tournament->shouldReceive('get')->once()->andReturn(new EloquentCollection());

        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute all
        $tournaments = $tournamentRepository->all();

        // Assertions
        $this->assertInstanceOf(EloquentCollection::class, $tournaments);
    }

    /**
     * Test create method of TournamentRepository
     */
    public function testCreate(): void
    {

        // Prepare data for create
        $teamsData = [
            ['name' => 'Team A', 'power' => 90],
            ['name' => 'Team B', 'power' => 80],
        ];
        $pairs = collect();
        // Instantiate TournamentRepository
        /**
         * @var object
         */
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $pair = Mockery::mock(Pair::class);

        $tournament->shouldReceive('create')->once()->andReturnSelf();
        $tournament->shouldReceive('teams')->once()->andReturnSelf();
        $tournament->shouldReceive('createMany')->once()->with($teamsData)->andReturnSelf();
        $tournament->shouldReceive('pairs')->once()->andReturn($pair);
        $pair->shouldReceive('createMany')->once()->with($pairs->toArray())->andReturn($pairs);
        $tournament->shouldReceive('push')->once()->andReturnSelf();
        $fixtureGenerator->shouldReceive('generate')->once()->with($tournament)->andReturn($pairs);

        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);


        // Execute create
        $createdTournament = $tournamentRepository->create($teamsData);

        // Assertions
        $this->assertInstanceOf(Tournament::class, $createdTournament);
        $this->assertEquals($tournament, $createdTournament);
    }

    /**
     * Test findById method of TournamentRepository
     */
    public function testFindById(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        /**
         * @var object
         */
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->once()->andReturnSelf();
        $tournament->shouldReceive('with')->once()->andReturnSelf();
        $tournament->shouldReceive('find')->once()->with($tournamentId)->andReturnSelf();
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute findById
        $retrievedTournament = $tournamentRepository->findById($tournamentId);

        // Assertions
        $this->assertInstanceOf(Tournament::class, $retrievedTournament);
        $this->assertEquals($tournament, $retrievedTournament);
    }

    /**
     * Test resetById method of TournamentRepository
     */
    public function testResetById(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        $pairs = collect();
        /**
         * @var object
         */
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $teamMock = Mockery::mock(Team::class);
        $pairMock = Mockery::mock(Pair::class);
        $teamMock->shouldReceive('get')->once()->with(['name', 'power'])->andReturnSelf();
        $teamMock->shouldReceive('createMany')->once()->andReturnSelf();
        $teamMock->shouldReceive('toArray')->once()->andReturnSelf();
        $pairMock->shouldReceive('createMany')->once()->andReturnSelf();
        $tournament->shouldReceive('find')->once()->with($tournamentId)->andReturnSelf();
        $tournament->shouldReceive('teams')->times(3)->andReturn($teamMock);
        $tournament->shouldReceive('pairs')->times(2)->andReturn($pairMock);
        $teamMock->shouldReceive('delete')->once()->andReturnSelf();
        $pairMock->shouldReceive('delete')->once()->andReturnSelf();
        $tournament->shouldReceive('push')->once()->andReturnSelf();
        $fixtureGenerator->shouldReceive('generate')->once()->with($tournament)->andReturn($pairs);
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute resetById
        $tournamentRepository->resetById($tournamentId);
    }

    /**
     * Test getCurrentWeek method of TournamentRepository
     */
    public function testGetCurrentWeek(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->once()->andReturnSelf();
        $tournament->shouldReceive('with')->once()->andReturnSelf();
        $tournament->shouldReceive('find')->once()->with($tournamentId)->andReturnSelf();
        $tournament->shouldReceive('pairs')->once()->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week')->andReturnSelf();
        $tournament->shouldReceive('where')->once()->with('played', false)->andReturnSelf();
        $tournament->shouldReceive('first')->once()->andReturnSelf();
        $tournament->shouldReceive('getAttribute')->once()->with('week')->andReturn(1);
        $tournament->shouldReceive('offsetExists')->once()->with('week')->andReturn(true);
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute getCurrentWeek
        $result = $tournamentRepository->getCurrentWeek($tournamentId);

        // Assertions
        $this->assertEquals(1, $result);
    }


    /**
     * Test getCurrentWeek method of TournamentRepository
     */
    public function testGetCurrentWeek_when_pair_not_found(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->once()->andReturnSelf();
        $tournament->shouldReceive('with')->once()->andReturnSelf();
        $tournament->shouldReceive('find')->once()->with($tournamentId)->andReturnSelf();
        $tournament->shouldReceive('pairs')->once()->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week')->andReturnSelf();
        $tournament->shouldReceive('where')->once()->with('played', false)->andReturnSelf();
        $tournament->shouldReceive('first')->once()->andReturnSelf();
        $tournament->shouldReceive('offsetExists')->once()->with('week')->andReturn(false);
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute getCurrentWeek
        $result = $tournamentRepository->getCurrentWeek($tournamentId);

        // Assertions
        $this->assertEquals(-1, $result);
    }

    /**
     * Test getRemainingWeekCount method of TournamentRepository
     */
    public function testGetCurrentWeekPairs(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->once()->andReturnSelf();
        $tournament->shouldReceive('with')->once()->andReturnSelf();
        $tournament->shouldReceive('find')->once()->with($tournamentId)->andReturnSelf();
        $tournament->shouldReceive('pairs')->once()->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week')->andReturnSelf();
        $tournament->shouldReceive('where')->once()->with('played', false)->andReturnSelf();
        $tournament->shouldReceive('first')->once()->andReturnSelf();
        $tournament->shouldReceive('offsetExists')->once()->with('week')->andReturn(false);
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute getCurrentWeekPairs
        $result = $tournamentRepository->getCurrentWeekPairs($tournamentId);

        // Assertions
        $this->assertInstanceOf(SupportCollection::class,$result);
    }

    /**
     * Test getCurrentWeek method of TournamentRepository
     */
    public function testGetRemainingWeekCount_when_not_exits(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->times(2)->andReturnSelf();
        $tournament->shouldReceive('with')->times(2)->andReturnSelf();
        $tournament->shouldReceive('find')->times(2)->with($tournamentId)->andReturnSelf();
        $tournament->shouldReceive('pairs')->times(2)->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week')->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week','desc')->andReturnSelf();
        $tournament->shouldReceive('where')->times(2)->with('played', false)->andReturnSelf();
        $tournament->shouldReceive('first')->times(2)->andReturnSelf();
        $tournament->shouldReceive('offsetExists')->times(2)->with('week')->andReturn(false);
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute getCurrentWeekPairs
        $result = $tournamentRepository->getRemainingWeekCount($tournamentId);

        // Assertions
        $this->assertEquals(0, $result);
    }


    /**
     * Test getCurrentWeek method of TournamentRepository
     */
    public function testGetRemainingWeekCount(): void
    {
        // Instantiate TournamentRepository
        $tournamentId = 1;
        $fixtureGenerator = Mockery::mock(FixtureGeneratorInterface::class);
        $tournament = Mockery::mock(Tournament::class);
        $tournament->shouldReceive('newQuery')->times(2)->andReturnSelf();
        $tournament->shouldReceive('with')->times(2)->andReturnSelf();
        $tournament->shouldReceive('find')->times(2)->with($tournamentId)->andReturnSelf();
        $tournament->shouldReceive('pairs')->times(2)->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week')->andReturnSelf();
        $tournament->shouldReceive('orderBy')->once()->with('week', 'desc')->andReturnSelf();
        $tournament->shouldReceive('where')->times(2)->with('played', false)->andReturnSelf();
        $tournament->shouldReceive('first')->times(2)->andReturnSelf();
        $tournament->shouldReceive('offsetExists')->times(2)->with('week')->andReturn(true);
        $tournament->shouldReceive('getAttribute')->times(2)->with('week')->andReturn(1);
        $tournamentRepository = new TournamentRepository($tournament, $fixtureGenerator);

        // Execute getCurrentWeekPairs
        $result = $tournamentRepository->getRemainingWeekCount($tournamentId);

        // Assertions
        $this->assertEquals(1, $result);
    }

}
