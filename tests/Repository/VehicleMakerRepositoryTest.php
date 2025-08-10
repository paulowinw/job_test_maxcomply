<?php

namespace App\Tests\Repository;

use App\Entity\VehicleMaker;
use App\Repository\VehicleMakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Doctrine\Persistence\ManagerRegistry;

class VehicleMakerRepositoryTest extends TestCase
{
    public function testFindMakersByVehicleType(): void
    {
        // 1. Arrange: Mock the necessary dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $managerRegistry = $this->createMock(ManagerRegistry::class);
        // Create a partial mock of ClassMetadata, only mocking getRootEntityName
        $classMetadata = $this->getMockBuilder(ClassMetadata::class)
            ->setConstructorArgs([VehicleMaker::class]) // Pass the entity class to the constructor
            ->getMock();
            

        $queryBuilder = $this->createMock(QueryBuilder::class);
        $query = $this->createMock(Query::class);

        // 2. Configure the mocks' behavior
        $managerRegistry->expects($this->once())
            ->method('getManagerForClass')
            ->with(VehicleMaker::class)
            ->willReturn($entityManager);

        $entityManager->expects($this->once())
            ->method('getClassMetadata')
            ->willReturn($classMetadata);

        $entityManager->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('select')
            ->with('vm')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('from')
            ->with(VehicleMaker::class, 'vm')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('join')
            ->with('vm.vehicles', 'v')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('where')
            ->with('v.type = :type')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('type', 'sedan')
            ->willReturnSelf();

        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $query->expects($this->once())
            ->method('getResult')
            ->willReturn(['Ford', 'Toyota']);

        // 3. Act: Instantiate the repository and call the method
        $repository = new VehicleMakerRepository($managerRegistry);
        $makers = $repository->findMakersByVehicleType('sedan');

        // 4. Assert: Verify the results
        $this->assertEquals(['Ford', 'Toyota'], $makers);
    }
}