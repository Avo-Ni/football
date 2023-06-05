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

        // Supprimer les données créées lors du test
        $entityManager = $client->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->getConnection()->beginTransaction();

        try {
            $team = $entityManager->getRepository(Team::class)->findOneBy(['name' => 'Test Team']);

            if ($team !== null) {
                // Supprimer les joueurs associés à l'équipe
                foreach ($team->getPlayers() as $player) {
                    $entityManager->remove($player);
                }

                // Supprimer l'équipe elle-même
                $entityManager->remove($team);
                $entityManager->flush();
            }

            $entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollBack();
            throw $e;
        }

        // Ajouter une nouvelle équipe avec des joueurs
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
