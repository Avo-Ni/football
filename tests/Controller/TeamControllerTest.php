<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Player;
use App\Entity\Team;

class TeamControllerTest extends WebTestCase
{
    public function testAddTeam(): void
    {
        $client = static::createClient();

        $teamData = [
            'name' => 'Test Team',
            'country' => 'Test Country',
            'moneyBalance' => 1000000,
            'players' => [
                [
                    'name' => 'John',
                    'surname' => 'Doe',
                ],
                [
                    'name' => 'Jane',
                    'surname' => 'Smith',
                ],
            ],
        ];

        // Delete the data created during the test
        $entityManager = $client->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->getConnection()->beginTransaction();

        try {
            $team = $entityManager->getRepository(Team::class)->findOneBy(['name' => 'Test Team']);

            if ($team !== null) {
                // Remove the players associated with the team
                foreach ($team->getPlayers() as $player) {
                    $entityManager->remove($player);
                }

                // Remove the team itself
                $entityManager->remove($team);
                $entityManager->flush();
            }

            $entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollBack();
            throw $e;
        }

        // Add a new team with players
        $client->request(
            'POST',
            '/teams',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['newTeam' => $teamData])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Team created successfully']),
            $client->getResponse()->getContent()
        );
    }
}
