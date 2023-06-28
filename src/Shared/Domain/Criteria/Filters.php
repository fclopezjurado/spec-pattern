<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use App\Shared\Domain\Collection;

final readonly class Filters extends Collection
{
    /**
     * @param array<int, array{field: string, operator: FilterOperator, value: string}> $values
     */
    public static function fromValues(array $values): self
    {
        return new self(array_map(fn (array $values) => Filter::fromValues($values), $values));
    }

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return $this->items();
    }

    public function serialize(): string
    {
        $serializedItems = array_map(fn (Filter $filter) => $filter->serialize(), $this->items());

        return implode('^', $serializedItems);
    }

    protected function type(): string
    {
        return Filter::class;
    }
}
