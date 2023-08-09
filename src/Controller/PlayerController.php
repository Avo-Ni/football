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
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function sellPlayer(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id']) || !isset($data['price'])) {
            return $this->json(['message' => 'Invalid data provided'], Response::HTTP_BAD_REQUEST);
        }

        $playerId = $data['id'];
        $price = $data['price'];

        $player = $this->playerRepository->find($playerId);

        if (!$player) {
            return $this->json(['message' => 'Player not found'], Response::HTTP_NOT_FOUND);
        }

        $player->setPrice($price);

        $validationErrors = $validator->validate($player);
        if (count($validationErrors) > 0) {
            return $this->json(['message' => 'Validation error', 'errors' => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Player listed for sale'], Response::HTTP_OK);
    }

    /**
     * @Route("/players/available", name="player_available", methods={"GET"})
     */
    public function getAvailablePlayers(): JsonResponse
    {
        $availablePlayers = $this->playerRepository->findAvailablePlayers();

        $playersData = array_map(function (Player $player) {
            return [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'surname' => $player->getSurname(),
                'price' => $player->getPrice(),
            ];
        }, $availablePlayers);

        return $this->json($playersData, Response::HTTP_OK);
    }

    /**
     * @Route("/players/transfer", name="player_transfer", methods={"POST"})
     */
    public function transferPlayer(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id']) || !isset($data['teamId'])) {
            return $this->json(['message' => 'Invalid data provided'], Response::HTTP_BAD_REQUEST);
        }

        $playerId = $data['id'];
        $teamId = $data['teamId'];

        $player = $this->playerRepository->find($playerId);
        $newTeam = $this->teamRepository->find($teamId);

        if (!$player || !$newTeam) {
            return $this->json(['message' => 'Player or new team not found'], Response::HTTP_NOT_FOUND);
        }

        $oldTeam = $player->getTeam();

        if ($newTeam->getMoneyBalance() < $player->getPrice()) {
            return $this->json(['message' => 'Insufficient funds in the new team'], Response::HTTP_BAD_REQUEST);
        }

        if ($player->getPrice() !== null) {
            $oldTeam->subtractMoney($player->getPrice());
        }

        $player->setTeam($newTeam);

        $newTeam->addMoney($player->getPrice());

        $player->setPrice(null);

        $validationErrors = $validator->validate($player);
        if (count($validationErrors) > 0) {
            return $this->json(['message' => 'Validation error', 'errors' => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Player transferred successfully'], Response::HTTP_OK);
    }
}
