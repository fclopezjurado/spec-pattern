<?php

declare(strict_types=1);

namespace App\Tests\E2E\Infrastructure;

use App\Domain\Car;
use App\Domain\Color;
use App\Infrastructure\CarRepositoryMySql;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use PHPUnit\Framework\TestCase;

class CarRepositoryMySqlTest extends TestCase
{
//    private const ENV_DIR = __DIR__.'/../../../';
//
    private static EntityManager $entityManager;

//
//    /**
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public static function setUpBeforeClass(): void
//    {
//        $configurationOptions = Setup::createAttributeMetadataConfiguration(
//            paths: [self::ENV_DIR.'src'],
//            isDevMode: true,
//        );
//        $dotenv = Dotenv::createImmutable(self::ENV_DIR);
//
//        $dotenv->load();
//
//        $connectionParameters = [
//            'dbname' => $_ENV['MYSQL_DATABASE'],
//            'user' => $_ENV['MYSQL_USER'],
//            'password' => $_ENV['MYSQL_PASSWORD'],
//            'host' => $_ENV['MYSQL_ROOT_HOST'],
//            'driver' => $_ENV['MYSQL_DRIVER'],
//        ];
//
//        self::$entityManager = EntityManager::create($connectionParameters, $configurationOptions);
//    }
    public static function setUpBeforeClass(): void
    {
        if (function_exists('getEntityManager')) {
            self::$entityManager = getEntityManager();
        }
    }

    /**
     * @param array{engine: array{type: string, code: string, alignment: string, position: string, size: int, numberOfValves: int, compressionRatio: float, fuel: array{type: string, system: string}}, color: Color, name: string, new: bool} $data
     * @dataProvider provideData
     * @throws \Doctrine\ORM\ORMException
     * @throws OptimisticLockException
     */
    public function testShouldSave(array $data): void
    {
        $repository = new CarRepositoryMySql(self::$entityManager);
        $car = (new Car())
            ->setColor($data['color'])
            ->setName($data['name'])
            ->setNew($data['new'])
        ;

        $repository->save($car);
    }

    /**
     * @return iterable<array<int, array{engine: array{type: string, code: string, alignment: string, position: string, size: int, numberOfValves: int, compressionRatio: float, fuel: array{type: string, system: string}}, color: Color, name: string, new: bool}>>
     */
    public function provideData(): iterable
    {
        yield [
            [
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
                        'system' => 'Direct Injection',
                    ],
                ],
                'color' => Color::RED,
                'name' => 'Acura TLX 2021',
                'new' => true,
            ],
        ];
    }
}
