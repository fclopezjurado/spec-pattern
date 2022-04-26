<?php

declare(strict_types=1);

namespace App\Domain;

use App\Shared\Domain\Criteria\Criteria;

interface CarRepository
{
    public function save(Car $car): void;

    public function searchByCriteria(Criteria $criteria): Cars;
}
