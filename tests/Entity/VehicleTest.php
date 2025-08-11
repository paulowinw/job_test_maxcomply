<?php

namespace App\Tests\Entity;

use App\Entity\Vehicle;
use App\Entity\VehicleMaker;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Vehicle entity.
 */
class VehicleTest extends TestCase
{
    private Vehicle $vehicle;
    private VehicleMaker $maker;

    /**
     * This method runs before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->vehicle = new Vehicle();
        $this->maker = $this->createMock(VehicleMaker::class);
    }

    /**
     * Test the getId() method.
     * The ID is an auto-generated field, so we can't set it directly.
     * We can only test that the initial value is null.
     */
    public function testGetId(): void
    {
        $this->assertNull($this->vehicle->getId());
    }

    /**
     * Test the getMaker() and setMaker() methods.
     */
    public function testSetAndGetMaker(): void
    {
        $this->vehicle->setMaker($this->maker);
        $this->assertSame($this->maker, $this->vehicle->getMaker());
    }

    /**
     * Test the getType() and setType() methods.
     */
    public function testSetAndGetType(): void
    {
        $type = 'Sedan';
        $this->vehicle->setType($type);
        $this->assertSame($type, $this->vehicle->getType());
    }

    /**
     * Test the getModel() and setModel() methods.
     */
    public function testSetAndGetModel(): void
    {
        $model = 'Model S';
        $this->vehicle->setModel($model);
        $this->assertSame($model, $this->vehicle->getModel());
    }

    /**
     * Test the getTopSpeed() and setTopSpeed() methods.
     */
    public function testSetAndGetTopSpeed(): void
    {
        $topSpeed = 250;
        $this->vehicle->setTopSpeed($topSpeed);
        $this->assertSame($topSpeed, $this->vehicle->getTopSpeed());
    }

    /**
     * Test the getEngineType() and setEngineType() methods.
     */
    public function testSetAndGetEngineType(): void
    {
        $engineType = 'V8';
        $this->vehicle->setEngineType($engineType);
        $this->assertSame($engineType, $this->vehicle->getEngineType());
    }

    /**
     * Test the getEnginePower() and setEnginePower() methods.
     */
    public function testSetAndGetEnginePower(): void
    {
        $enginePower = 500;
        $this->vehicle->setEnginePower($enginePower);
        $this->assertSame($enginePower, $this->vehicle->getEnginePower());
    }

    /**
     * Test the getFuelType() and setFuelType() methods.
     */
    public function testSetAndGetFuelType(): void
    {
        $fuelType = 'Petrol';
        $this->vehicle->setFuelType($fuelType);
        $this->assertSame($fuelType, $this->vehicle->getFuelType());
    }

    /**
     * Test the getLength() and setLength() methods.
     */
    public function testSetAndGetLength(): void
    {
        $length = '4.50';
        $this->vehicle->setLength($length);
        $this->assertSame($length, $this->vehicle->getLength());
    }

    /**
     * Test the getWidth() and setWidth() methods.
     */
    public function testSetAndGetWidth(): void
    {
        $width = '1.80';
        $this->vehicle->setWidth($width);
        $this->assertSame($width, $this->vehicle->getWidth());
    }

    /**
     * Test the getHeight() and setHeight() methods.
     */
    public function testSetAndGetHeight(): void
    {
        $height = '1.40';
        $this->vehicle->setHeight($height);
        $this->assertSame($height, $this->vehicle->getHeight());
    }

    /**
     * Test the getWeight() and setWeight() methods.
     */
    public function testSetAndGetWeight(): void
    {
        $weight = '1500.50';
        $this->vehicle->setWeight($weight);
        $this->assertSame($weight, $this->vehicle->getWeight());
    }

    /**
     * Test the getNumberOfSeats() and setNumberOfSeats() methods.
     */
    public function testSetAndGetNumberOfSeats(): void
    {
        $numberOfSeats = 5;
        $this->vehicle->setNumberOfSeats($numberOfSeats);
        $this->assertSame($numberOfSeats, $this->vehicle->getNumberOfSeats());
    }

    /**
     * Test the getZeroToHundredTime() and setZeroToHundredTime() methods.
     */
    public function testSetAndGetZeroToHundredTime(): void
    {
        $zeroToHundredTime = '3.2';
        $this->vehicle->setZeroToHundredTime($zeroToHundredTime);
        $this->assertSame($zeroToHundredTime, $this->vehicle->getZeroToHundredTime());
    }
}
