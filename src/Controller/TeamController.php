<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TeamController extends AbstractController
{
    private $teamRepository;
    private $playerRepository;

    public function __construct(TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @Route("/team", name="app_team")
     */
    public function index(): Response
    {
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }

    /**
     * @Route("/teams/players", name="teams_players", methods={"GET"})
     */
    public function getAllTeamsAndPlayers(): JsonResponse
    {
        $teams = $this->teamRepository->findAllWithPlayers();

        $data = [];
        foreach ($teams as $team) {
            $teamData = [
                'id' => $team->getId(),
                'name' => $team->getName(),
                'country' => $team->getCountry(),
                'moneyBalance' => $team->getMoneyBalance(),
                'players' => [],
            ];

            foreach ($team->getPlayers() as $player) {
                $teamData['players'][] = [
                    'id' => $player->getId(),
                    'name' => $player->getName(),
                    'surname' => $player->getSurname(),
                ];
            }

            $data[] = $teamData;
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/teams", methods={"POST"})
     */
    /**
     * @Route("/teams", methods={"POST"})
     */
    public function addTeam(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $this->validateTeamData($data);

            $team = $this->createTeamFromData($data);

            $this->entityManager->persist($team);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Team created successfully'], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error creating team: ' . $e->getMessage()], 500);
        }
    }

    private function validateTeamData(array $data): void
    {
        if (!isset($data['newTeam'])) {
            throw new \InvalidArgumentException('Invalid data provided');
        }

        $newTeamData = $data['newTeam'];

        if (!isset($newTeamData['name']) || !isset($newTeamData['country']) || !isset($newTeamData['moneyBalance']) || !isset($newTeamData['players'])) {
            throw new \InvalidArgumentException('Invalid team data provided');
        }
    }

    private function createTeamFromData(array $data): Team
    {
        $newTeamData = $data['newTeam'];

        $team = new Team();
        $team->setName($newTeamData['name']);
        $team->setCountry($newTeamData['country']);
        $team->setMoneyBalance($newTeamData['moneyBalance']);

        foreach ($newTeamData['players'] as $playerData) {
            $player = new Player();
            $player->setName($playerData['name']);
            $player->setSurname($playerData['surname']);
            $player->setTeam($team);

            $this->entityManager->persist($player);
        }

        return $team;
    }
}
