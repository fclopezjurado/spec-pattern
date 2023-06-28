<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Car;
use App\Domain\CarRepository;
use App\Domain\Cars;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Infrastructure\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\DoctrineRepository;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final class CarRepositoryMySql extends DoctrineRepository implements CarRepository
{
    public const ID_DOCTRINE_FIELD = 'id';
    public const ENGINE_DOCTRINE_FIELD = 'engine';
    public const COLOR_DOCTRINE_FIELD = 'color';
    public const NAME_DOCTRINE_FIELD = 'name';
    public const NEW_DOCTRINE_FIELD = 'new';
    private const CRITERIA_TO_DOCTRINE_FIELDS = [
        Car::ID_FIELD_NAME => self::ID_DOCTRINE_FIELD,
        Car::ENGINE_FIELD_NAME => self::ENGINE_DOCTRINE_FIELD,
        Car::COLOR_FIELD_NAME => self::COLOR_DOCTRINE_FIELD,
        Car::NAME_FIELD_NAME => self::NAME_DOCTRINE_FIELD,
        Car::NEW_FIELD_NAME => self::NEW_DOCTRINE_FIELD,
    ];

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Car $car): void
    {
        $this->persist($car);
    }

    /**
     * @throws NotSupported
     */
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
