<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure;

use App\Domain\Car;
use App\Domain\CarFactory;
use App\Domain\Color;
use App\Infrastructure\CarRepositoryMySql;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\FilterOperator;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMSetup;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class CarRepositoryShould extends TestCase
{
    private static EntityManager $entityManager;

    public static function setUpBeforeClass(): void
    {
        try {
            $configuration = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__.'/../../src/Domain'],
                isDevMode: true,
            );
            $connection = DriverManager::getConnection([
                'dbname' => $_ENV['MYSQL_DATABASE'],
                'user' => $_ENV['MYSQL_USER'],
                'password' => $_ENV['MYSQL_PASSWORD'],
                'host' => $_ENV['MYSQL_HOST'],
                'driver' => $_ENV['MYSQL_DRIVER'],
            ], $configuration);

            self::$entityManager = new EntityManager($connection, $configuration);
        } catch (\Throwable $exception) {
            var_dump($exception->getMessage());
        }
    }

    /**
     * @param array{car: array{engine: array{type: string, code: string, alignment: string,
     *     position: string, size: int, numberOfValves: int, compressionRatio: float, fuel: array{type: string,
     *     design: string}}, color: Color, name: string, new: bool}, filter: array{field: string,
     *     operator: FilterOperator, value: string}} $data
     *
     * @throws OptimisticLockException|ORMException
     */
    #[Test]
    #[DataProvider('provideDataToSaveCar')]
    #[TestDox('Saves a car')]
    public function save(array $data): void
    {
        $repository = new CarRepositoryMySql(self::$entityManager);
        $car = CarFactory::build($data['car']);

        $repository->save($car);

        /** @var Car $fetchedCar */
        $fetchedCar = $repository->searchByCriteria($this->buildCriteria($data['filter']))->getIterator()->current();

        self::assertSame($data['car']['name'], $fetchedCar->getName());
    }

    /**
     * @param array{field: string, operator: FilterOperator, value: string} $filterData
     */
    private function buildCriteria(array $filterData): Criteria
    {
        return new Criteria(
            filters: Filters::fromValues([$filterData]),
            order: Order::none(),
            offset: null,
            limit: null
        );
    }

    /**
     * @return iterable<array<int, array{car: array{engine: array{type: string, code: string, alignment: string,
     *     position: string, size: int, numberOfValves: int, compressionRatio: float, fuel: array{type: string,
     *     design: string}}, color: Color, name: string, new: bool}, filter: array{field: string,
     *     operator: FilterOperator, value: string}}>>
     */
    public static function provideDataToSaveCar(): iterable
    {
        yield [
            [
                'car' => [
                    'engine' => [
                        'type' => 'Inline 4',
                        'code' => 'Honda K20C-series',
                        'alignment' => 'Transverse',
                        'position' => 'Front',
                        'size' => 1996,
                        'numberOfValves' => 16,
                        'compressionRatio' => 9.8,
                        'fuel' => [
                            'type' => 'Petrol',
                            'design' => 'Direct Injection',
                        ],
                    ],
                    'color' => Color::RED,
                    'name' => 'Acura TLX 2021',
                    'new' => true,
                ],
                'filter' => [
                    'field' => Car::NAME_FIELD_NAME,
                    'operator' => FilterOperator::EQUAL,
                    'value' => 'Acura TLX 2021',
                ],
            ],
        ];
    }
}
