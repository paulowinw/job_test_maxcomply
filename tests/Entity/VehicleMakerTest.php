<?php

namespace App\Tests\Entity;

use App\Entity\VehicleMaker;
use PHPUnit\Framework\TestCase;

class VehicleMakerTest extends TestCase
{
    public function testGetName(): void
    {
        $maker = new VehicleMaker();
        $maker->setName('Ford');

        $this->assertEquals('Ford', $maker->getName());
    }

    public function testGetIdInitiallyNull(): void
    {
        $maker = new VehicleMaker();

        $this->assertNull($maker->getId());
    }
}