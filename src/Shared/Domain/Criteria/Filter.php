<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use JetBrains\PhpStorm\Pure;

final class Filter
{
    public function __construct(
        private FilterField $field,
        private FilterOperator $operator,
        private FilterValue $value)
    {
    }

    /**
     * @param array{field: string, operator: FilterOperator, value: string} $values
     *
     * @return Filter
     */
    #[Pure]
    public static function fromValues(array $values): self
    {
        return new self(
            field: new FilterField($values['field']),
            operator: $values['operator'],
            value: new FilterValue($values['value'])
        );
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }

    #[Pure]
    public function serialize(): string
    {
        return sprintf('%s.%s.%s', $this->field->value(), $this->operator->value, $this->value->value());
    }
}
