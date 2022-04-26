<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use JetBrains\PhpStorm\Pure;

class Criteria
{
    public function __construct(
        private Filters $filters,
        private Order $order,
        private ?int $offset,
        private ?int $limit
    ) {
    }

    #[Pure]
    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    #[Pure]
    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    /**
     * @return Filter[]
     */
    #[Pure]
    public function plainFilters(): array
    {
        return $this->filters->filters();
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s',
            $this->filters->serialize(),
            $this->order->serialize(),
            $this->offset,
            $this->limit
        );
    }
}