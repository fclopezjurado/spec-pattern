<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;

/**
 * @implements IteratorAggregate<int, mixed>
 */
abstract class Collection implements Countable, IteratorAggregate
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
     * @return ArrayIterator<int, mixed>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    #[Pure]
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

    protected function add(mixed $item): self
    {
        Assert::instanceOf($this->type(), $item);

        $this->items[] = $item;

        return $this;
    }
}
