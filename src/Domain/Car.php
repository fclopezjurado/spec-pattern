<?php

declare(strict_types=1);

namespace App\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'car')]
final class Car extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Engine::class)]
    #[ORM\JoinColumn(name: 'engine_id', referencedColumnName: 'id')]
    private Engine $engine;

    #[ORM\Column(type: 'string', length: 32)]
    private Color $color;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    private bool $new;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function engine(): Engine
    {
        return $this->engine;
    }

    public function setEngine(Engine $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    public function color(): Color
    {
        return $this->color;
    }

    public function setColor(Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function new(): bool
    {
        return $this->new;
    }

    public function setNew(bool $new): self
    {
        $this->new = $new;

        return $this;
    }
}
