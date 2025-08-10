<?php

namespace App\Tests\Entity;

use App\Entity\Vehicle;
use App\Entity\VehicleMaker;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testGetAndSetProperties(): void
    {
        $vehicle = new Vehicle();
        $maker = new VehicleMaker();
        $maker->setName('Tesla');

        $vehicle->setMaker($maker);
        $vehicle->setType('EV');
        $vehicle->setModel('Model S');
        $vehicle->setTopSpeed(250);

        $this->assertEquals($maker, $vehicle->getMaker());
        $this->assertEquals('EV', $vehicle->getType());
        $this->assertEquals('Model S', $vehicle->getModel());
        $this->assertEquals(250, $vehicle->getTopSpeed());
    }

    public function testIdInitiallyNull(): void
    {
        $vehicle = new Vehicle();
        $this->assertNull($vehicle->getId());
    }
}