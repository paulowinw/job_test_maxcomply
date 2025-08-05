<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?VehicleMaker $maker = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(nullable: true)]
    private ?int $topSpeed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $engineType = null;

    #[ORM\Column(nullable: true)]
    private ?int $enginePower = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fuelType = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $length = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $width = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $height = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfSeats = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $zeroToHundredTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaker(): ?VehicleMaker
    {
        return $this->maker;
    }

    public function setMaker(?VehicleMaker $maker): static
    {
        $this->maker = $maker;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getTopSpeed(): ?int
    {
        return $this->topSpeed;
    }

    public function setTopSpeed(?int $topSpeed): static
    {
        $this->topSpeed = $topSpeed;

        return $this;
    }

    public function getEngineType(): ?string
    {
        return $this->engineType;
    }

    public function setEngineType(?string $engineType): static
    {
        $this->engineType = $engineType;

        return $this;
    }

    public function getEnginePower(): ?int
    {
        return $this->enginePower;
    }

    public function setEnginePower(?int $enginePower): static
    {
        $this->enginePower = $enginePower;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(?string $fuelType): static
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(?string $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(?string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getNumberOfSeats(): ?int
    {
        return $this->numberOfSeats;
    }

    public function setNumberOfSeats(?int $numberOfSeats): static
    {
        $this->numberOfSeats = $numberOfSeats;

        return $this;
    }

    public function getZeroToHundredTime(): ?string
    {
        return $this->zeroToHundredTime;
    }

    public function setZeroToHundredTime(?string $zeroToHundredTime): static
    {
        $this->zeroToHundredTime = $zeroToHundredTime;

        return $this;
    }
}
