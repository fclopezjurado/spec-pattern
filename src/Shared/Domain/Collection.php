<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, mixed>
 */
abstract readonly class Collection implements \Countable, \IteratorAggregate
{
    /**
     * @param array<int, mixed> $items
     */
    public function __construct(private array $items)
    {
        Assert::arrayOf($this->type(), $items);
    }

    abstract protected function type(): string;

    /**
     * @return \ArrayIterator<int, mixed>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    /**
     * @return array<int, mixed>
     */
    protected function items(): array
    {
        return $this->items;
    }
}
