<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/generate-players-teams", name="generate_players_teams")
     */
    public function generatePlayersAndTeams(): Response
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $team = new Team();
            $team->setName($faker->company);
            $team->setCountry($faker->country);
            $team->setMoneyBalance($faker->randomNumber(6));

            $this->entityManager->persist($team);

            for ($j = 0; $j < 10; $j++) {
                $player = new Player();
                $player->setName($faker->firstName);
                $player->setSurname($faker->lastName);
                $player->setTeam($team);

                $this->entityManager->persist($player);
            }
        }

        $this->entityManager->flush();

        return new Response('Players and teams generated successfully.');
    }
}
