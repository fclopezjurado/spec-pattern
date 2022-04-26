<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use JetBrains\PhpStorm\Pure;

final class Order
{
    public function __construct(private OrderBy $by, private OrderType $type)
    {
    }

    #[Pure]
    public static function createDesc(OrderBy $by): Order
    {
        return new self($by, OrderType::DESC);
    }

    public static function fromValues(?string $by, ?OrderType $type): Order
    {
        return null === $by ? self::none() : new Order(new OrderBy($by), $type);
    }

    #[Pure]
    public static function none(): Order
    {
        return new Order(new OrderBy(''), OrderType::NONE);
    }

    public function by(): OrderBy
    {
        return $this->by;
    }

    public function type(): OrderType
    {
        return $this->type;
    }

    public function isNone(): bool
    {
        return OrderType::NONE === $this->type;
    }

    #[Pure]
    public function serialize(): string
    {
        return sprintf('%s.%s', $this->by->value(), $this->type->value);
    }
}
