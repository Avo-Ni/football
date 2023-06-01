<?php

namespace App\Tests\Controller;

use App\Controller\TeamController;
use App\Entity\Player;
use App\Entity\Team;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TeamControllerTest extends TestCase
{
    private $teamRepository;
    private $playerRepository;

    private $teamController;

    protected function setUp(): void
    {
        $this->teamRepository = $this->createMock(TeamRepository::class);
        $this->playerRepository = $this->createMock(PlayerRepository::class);

        $this->teamController = new TeamController($this->teamRepository, $this->playerRepository);
    }

    public function testGetAllTeamsAndPlayers()
    {
        $team1 = new Team();
        $team1->setName('Team 1');
        $team1->setCountry('Country 1');
        $team1->setMoneyBalance(100000);

        $player1 = new Player();
        $player1->setName('Player 1');
        $player1->setSurname('Surname 1');
        $player1->setTeam($team1);

        $player2 = new Player();
        $player2->setName('Player 2');
        $player2->setSurname('Surname 2');
        $player2->setTeam($team1);

        $team1->addPlayer($player1);
        $team1->addPlayer($player2);

        $team2 = new Team();
        $team2->setName('Team 2');
        $team2->setCountry('Country 2');
        $team2->setMoneyBalance(200000);

        $expectedData = [
            [
                'name' => 'Team 1',
                'country' => 'Country 1',
                'moneyBalance' => 100000,
                'players' => [
                    [
                        'name' => 'Player 1',
                        'surname' => 'Surname 1',
                    ],
                    [
                        'name' => 'Player 2',
                        'surname' => 'Surname 2',
                    ],
                ],
            ],
            [
                'name' => 'Team 2',
                'country' => 'Country 2',
                'moneyBalance' => 200000,
                'players' => [],
            ],
        ];

        $this->teamRepository->expects($this->once())
            ->method('findAllWithPlayers')
            ->willReturn([$team1, $team2]);

        $response = $this->teamController->getAllTeamsAndPlayers();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(json_encode($expectedData), $response->getContent());
    }

    public function testAddTeam()
    {
        $requestPayload = '{
            "newTeam": {
                "name": "Test Team",
                "country": "Test Country",
                "moneyBalance": 100000,
                "players": [
                    {
                        "name": "Player 1",
                        "surname": "Surname 1"
                    },
                    {
                        "name": "Player 2",
                        "surname": "Surname 2"
                    }
                ]
            }
        }';

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getContent')
            ->willReturn($requestPayload);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Team::class))
            ->willReturnCallback(function (Team $team) use ($entityManager) {
                $team->setId(1);
                $players = $team->getPlayers();
                foreach ($players as $player) {
                    $player->setId(1);
                    $entityManager->persist($player);
                }
            });
        $entityManager->expects($this->once())
            ->method('flush');

        $team = new Team();
        $this->teamRepository->expects($this->once())
            ->method('createTeam')
            ->willReturn($team);

        $this->teamRepository->expects($this->once())
            ->method('findAllWithPlayers')
            ->willReturn([]);

        $this->playerRepository->expects($this->once())
            ->method('findAvailablePlayers')
            ->willReturn([]);

        $this->teamController->setContainer($this->createMock(\Symfony\Component\DependencyInjection\ContainerInterface::class));

        $response = $this->teamController->addTeam($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(json_encode(['message' => 'Team created successfully']), $response->getContent());
        $this->assertSame(201, $response->getStatusCode());
    }
}
