<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends AbstractController
{
    private $playerRepository;
    private $teamRepository;
    private $entityManager;

    public function __construct(
        PlayerRepository $playerRepository,
        TeamRepository $teamRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/player", name="app_player")
     */
    public function index(): Response
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/players/sell", name="player_sell", methods={"POST"})
     */
    public function sellPlayer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id']) || !isset($data['price'])) {
            return new JsonResponse(['message' => 'Invalid data provided'], Response::HTTP_BAD_REQUEST);
        }

        $playerId = $data['id'];
        $price = $data['price'];

        // Retrieve the player
        $player = $this->playerRepository->find($playerId);

        if (!$player) {
            return new JsonResponse(['message' => 'Player not found'], Response::HTTP_NOT_FOUND);
        }

        // Set the price of the player
        $player->setPrice($price);

        // Save the changes
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Player listed for sale'], Response::HTTP_OK);
    }

    /**
     * @Route("/players/available", name="player_available", methods={"GET"})
     */
    public function getAvailablePlayers(): JsonResponse
    {
        $availablePlayers = $this->playerRepository->findAvailablePlayers();

        $playersData = [];

        foreach ($availablePlayers as $player) {
            $playerData = [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'surname' => $player->getSurname(),
                'price' => $player->getPrice(),
            ];

            $playersData[] = $playerData;
        }

        return new JsonResponse($playersData, Response::HTTP_OK);
    }

    /**
     * @Route("/players/transfer", name="player_transfer", methods={"POST"})
     */
    public function transferPlayer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id']) || !isset($data['teamId'])) {
            return new JsonResponse(['message' => 'Invalid data provided'], Response::HTTP_BAD_REQUEST);
        }

        $playerId = $data['id'];
        $teamId = $data['teamId'];

        // Retrieve the player and new team
        $player = $this->playerRepository->find($playerId);
        $newTeam = $this->teamRepository->find($teamId);

        if (!$player || !$newTeam) {
            return new JsonResponse(['message' => 'Player or new team not found'], Response::HTTP_NOT_FOUND);
        }

        $oldTeam = $player->getTeam();

        // Check if the new team has enough money balance
        if ($newTeam->getMoneyBalance() < $player->getPrice()) {
            return new JsonResponse(['message' => 'Insufficient funds in the new team'], Response::HTTP_BAD_REQUEST);
        }

        // Subtract player's price from old team's money balance
        if ($player->getPrice() !== null) {
            $oldTeam->subtractMoney($player->getPrice());
        }

        // Set the new team for the player
        $player->setTeam($newTeam);

        // Add player's price to the new team's money balance
        $newTeam->addMoney($player->getPrice());

        // Reset the price of the player
        $player->setPrice(null);

        // Save the changes
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Player transferred successfully'], Response::HTTP_OK);
    }
}
