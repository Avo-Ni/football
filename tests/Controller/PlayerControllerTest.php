<?php

namespace App\Tests\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PlayerControllerTest extends WebTestCase
{
    public function testSellPlayer(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/players/sell',
            [],
            [],
            [],
            json_encode(['id' => 1, 'price' => 100])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetAvailablePlayers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/players/available');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testTransferPlayer(): void
    {
        $client = static::createClient();
        $teamId = $this->createTeam();

        $client->request(
            'POST',
            '/players/transfer',
            [],
            [],
            [],
            json_encode(['id' => 1, 'teamId' => $teamId])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    private function createTeam(): int
    {
        $team = new Team();
        $team->setName('Team Name');
        $team->setCountry('Team Country');
        $team->setMoneyBalance(100); 

        $entityManager = self::$container->get('doctrine')->getManager();
        $entityManager->persist($team);
        $entityManager->flush();

        return $team->getId();
    }
}