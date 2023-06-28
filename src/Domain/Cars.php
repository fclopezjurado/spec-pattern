<?php

declare(strict_types=1);

namespace App\Domain;

use App\Shared\Domain\Collection;

final readonly class Cars extends Collection
{
    protected function type(): string
    {
        return Car::class;
    }
}
