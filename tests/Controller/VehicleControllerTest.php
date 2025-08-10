<?php

namespace App\Tests\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleMaker;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


class VehicleControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        // Truncate entities before each test
        $this->truncateEntities();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Clean up database after each test
        $this->truncateEntities();

        $this->entityManager->close();
        $this->entityManager = null;
        $this->client = null;
    }

    private function truncateEntities(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        // Disable foreign key checks
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');

        try {
            $this->entityManager->getClassMetadata(Vehicle::class);
            $tableName = $this->entityManager->getClassMetadata(Vehicle::class)->getTableName();
            $connection->executeStatement($platform->getTruncateTableSQL($tableName, true));
        } catch (\Exception $e) {
            // Handle exception if the entity does not exist
        }

        try {
            $this->entityManager->getClassMetadata(VehicleMaker::class);
            $tableName = $this->entityManager->getClassMetadata(VehicleMaker::class)->getTableName();
            $connection->executeStatement($platform->getTruncateTableSQL($tableName, true));
        } catch (\Exception $e) {
            // Handle exception if the entity does not exist
        }

        // Re-enable foreign key checks
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    private function createData()
    {
        $maker = new VehicleMaker();
        $maker->setName('Toyota');
        $this->entityManager->persist($maker);

        $vehicle = new Vehicle();
        $vehicle->setMaker($maker);
        $vehicle->setType('Sedan');
        $vehicle->setModel('Corolla');
        $vehicle->setTopSpeed(180);
        $vehicle->setEngineType('Petrol');
        $this->entityManager->persist($vehicle);

        $this->entityManager->flush();

        return $vehicle;
    }

    public function testGetMakersByVehicleTypeSuccessfully(): void
    {
        // GIVEN
        $this->createData();

        // WHEN
        $this->client->request('GET', '/api/vehicles/makers?type=Sedan', [], [], [
            'HTTP_X-AUTH-TOKEN' => 'my-secret-token'
        ]);

        // THEN
        $this->assertResponseIsSuccessful();
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertCount(1, $responseContent);
        $this->assertEquals('Toyota', $responseContent[0]['name']);
    }

    public function testGetVehicleDetailsSuccessfully(): void
    {
        // GIVEN
        $vehicle = $this->createData();

        // WHEN
        $this->client->request('GET', '/api/vehicles/' . $vehicle->getId(), [], [], [
            'HTTP_X-AUTH-TOKEN' => 'my-secret-token'
        ]);

        // THEN
        $this->assertResponseIsSuccessful();
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($vehicle->getId(), $responseContent['id']);
        $this->assertEquals('Corolla', $responseContent['model']);
    }

    public function testUpdateVehicleParameterSuccessfully(): void
    {
        // GIVEN
        $vehicle = $this->createData();
        $newTopSpeed = 200;

        // WHEN
        $this->client->request('PATCH', '/api/vehicles/' . $vehicle->getId(), [], [], [
            'HTTP_X-AUTH-TOKEN' => 'my-secret-token',
            'CONTENT_TYPE' => 'application/json'
        ], json_encode(['topSpeed' => $newTopSpeed]));

        // THEN
        $this->assertResponseIsSuccessful();
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($newTopSpeed, $responseContent['topSpeed']);

        // Verify the change in the database
        $updatedVehicle = $this->entityManager->getRepository(Vehicle::class)->find($vehicle->getId());
        $this->assertEquals($newTopSpeed, $updatedVehicle->getTopSpeed());
    }

    public function testUpdateVehicleParameterWithoutAuthorizationFails(): void
    {
        // GIVEN
        $vehicle = $this->createData();

        // WHEN
        $this->client->request('PATCH', '/api/vehicles/' . $vehicle->getId(), [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode(['topSpeed' => 200]));

        // THEN
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}