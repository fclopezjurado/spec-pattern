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

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $type;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $code;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $alignment;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $position;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $size;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $numberOfValves;

    #[ORM\Column(type: 'float', nullable: false)]
    private float $compressionRatio;

    #[ORM\ManyToOne(targetEntity: Fuel::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'fuel_id', referencedColumnName: 'id', nullable: false)]
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

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function alignment(): string
    {
        return $this->alignment;
    }

    public function setAlignment(string $alignment): self
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function position(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function numberOfValves(): int
    {
        return $this->numberOfValves;
    }

    public function setNumberOfValves(int $numberOfValves): self
    {
        $this->numberOfValves = $numberOfValves;

        return $this;
    }

    public function compressionRatio(): float
    {
        return $this->compressionRatio;
    }

    public function setCompressionRatio(float $compressionRatio): self
    {
        $this->compressionRatio = $compressionRatio;

        return $this;
    }

    public function fuel(): Fuel
    {
        return $this->fuel;
    }

    public function setFuel(Fuel $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }
}
