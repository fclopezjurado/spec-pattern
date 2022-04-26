<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Car;
use App\Domain\CarRepository;
use App\Domain\Cars;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Infrastructure\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\DoctrineRepository;
use Doctrine\ORM\OptimisticLockException;

final class CarRepositoryMySql extends DoctrineRepository implements CarRepository
{
    private const CRITERIA_TO_DOCTRINE_FIELDS = [
        'id' => 'id',
        'engine' => 'engine',
        'color' => 'color',
        'new' => 'new',
    ];

    /**
     * @throws OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Car $car): void
    {
        $this->persist($car);
    }

    public function searchByCriteria(Criteria $criteria): Cars
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert(
            criteria: $criteria,
            criteriaToDoctrineFields: self::CRITERIA_TO_DOCTRINE_FIELDS
        );
        $cars = $this->repository(Car::class)->matching($doctrineCriteria)->toArray();

        return new Cars($cars);
    }
}
