<?php

declare(strict_types=1);

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'engine')]
final class Engine
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $type;

    #[ORM\Column(type: 'string', length: 255)]
    private string $code;

    #[ORM\Column(type: 'string', length: 255)]
    private string $alignment;

    #[ORM\Column(type: 'string', length: 255)]
    private string $position;

    #[ORM\Column(type: 'integer')]
    private int $size;

    #[ORM\Column(type: 'integer')]
    private int $numberOfValves;

    #[ORM\Column(type: 'float')]
    private float $compressionRatio;

    #[ORM\ManyToOne(targetEntity: Fuel::class)]
    #[ORM\JoinColumn(name: 'fuel_id', referencedColumnName: 'id')]
    private Fuel $fuel;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function alignment(): string
    {
        return $this->alignment;
    }

    public function setAlignment(string $alignment): void
    {
        $this->alignment = $alignment;
    }

    public function position(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function numberOfValves(): int
    {
        return $this->numberOfValves;
    }

    public function setNumberOfValves(int $numberOfValves): void
    {
        $this->numberOfValves = $numberOfValves;
    }

    public function compressionRatio(): float
    {
        return $this->compressionRatio;
    }

    public function setCompressionRatio(float $compressionRatio): void
    {
        $this->compressionRatio = $compressionRatio;
    }

    public function fuel(): Fuel
    {
        return $this->fuel;
    }

    public function setFuel(Fuel $fuel): void
    {
        $this->fuel = $fuel;
    }
}
