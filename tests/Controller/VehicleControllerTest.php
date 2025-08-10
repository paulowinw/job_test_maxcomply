<?php

namespace App\Tests\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleMaker;
use App\Repository\VehicleRepository;
use App\Repository\VehicleMakerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Collections\ArrayCollection;

class VehicleControllerTest extends WebTestCase
{
    private static $client;
    private static $entityManager;

    public static function setUpBeforeClass(): void
    {
        self::$client = static::createClient();
        self::$entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public static function tearDownAfterClass(): void
    {
        // Clean up database after all tests
        self::truncateEntities();

        self::$entityManager = null;
        self::$client = null;
    }

    private static function truncateEntities(): void
    {
        $connection = self::$entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        // Disable foreign key checks
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');

        try {
            self::$entityManager->getClassMetadata(Vehicle::class);
            $tableName = self::$entityManager->getClassMetadata(Vehicle::class)->getTableName();
            $connection->executeStatement($platform->getTruncateTableSQL($tableName, true));
        } catch (\Exception $e) {
            // Handle exception if the entity does not exist
        }

        try {
            self::$entityManager->getClassMetadata(VehicleMaker::class);
            $tableName = self::$entityManager->getClassMetadata(VehicleMaker::class)->getTableName();
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
        self::$entityManager->persist($maker);

        $vehicle = new Vehicle();
        $vehicle->setMaker($maker);
        $vehicle->setType('Sedan');
        $vehicle->setModel('Corolla');
        $vehicle->setTopSpeed(180);
        $vehicle->setEngineType('Petrol');
        self::$entityManager->persist($vehicle);

        self::$entityManager->flush();

        return $vehicle;
    }

    public function testGetMakersByVehicleTypeSuccessfully(): void
    {
        // GIVEN
        $this->createData();

        // WHEN
        self::$client->request('GET', '/api/vehicles/makers?type=Sedan', [], [], [
            'HTTP_X-AUTH-TOKEN' => 'my-secret-token'
        ]);

        // THEN
        $this->assertResponseIsSuccessful();
        $responseContent = json_decode(self::$client->getResponse()->getContent(), true);
        $this->assertCount(1, $responseContent);
        $this->assertEquals('Toyota', $responseContent[0]['name']);
    }

    public function testGetVehicleDetailsSuccessfully(): void
    {
        // GIVEN
        $vehicle = $this->createData();

        // WHEN
        self::$client->request('GET', '/api/vehicles/' . $vehicle->getId(), [], [], [
            'HTTP_X-AUTH-TOKEN' => 'my-secret-token'
        ]);

        // THEN
        $this->assertResponseIsSuccessful();
        $responseContent = json_decode(self::$client->getResponse()->getContent(), true);
        $this->assertEquals($vehicle->getId(), $responseContent['id']);
        $this->assertEquals('Corolla', $responseContent['model']);
    }

    public function testUpdateVehicleParameterSuccessfully(): void
    {
        // GIVEN
        $vehicle = $this->createData();
        $newTopSpeed = 200;

        // WHEN
        self::$client->request('PATCH', '/api/vehicles/' . $vehicle->getId(), [], [], [
            'HTTP_X-AUTH-TOKEN' => 'my-secret-token',
            'CONTENT_TYPE' => 'application/json'
        ], json_encode(['topSpeed' => $newTopSpeed]));

        // THEN
        $this->assertResponseIsSuccessful();
        $responseContent = json_decode(self::$client->getResponse()->getContent(), true);
        $this->assertEquals($newTopSpeed, $responseContent['topSpeed']);

        // Verify the change in the database
        $updatedVehicle = self::$entityManager->getRepository(Vehicle::class)->find($vehicle->getId());
        $this->assertEquals($newTopSpeed, $updatedVehicle->getTopSpeed());
    }

    public function testUpdateVehicleParameterWithoutAuthorizationFails(): void
    {
        // GIVEN
        $vehicle = $this->createData();

        // WHEN
        self::$client->request('PATCH', '/api/vehicles/' . $vehicle->getId(), [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode(['topSpeed' => 200]));

        // THEN
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}