<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;

require_once __DIR__.'/../vendor/autoload.php';

/**
 * @throws MissingMappingDriverImplementation
 * @throws \Doctrine\DBAL\Exception
 */
function getEntityManager(): EntityManager
{
    $configuration = ORMSetup::createAttributeMetadataConfiguration(
        paths: [__DIR__.'/Domain'],
        isDevMode: true,
    );
    $connection = DriverManager::getConnection([
        'dbname' => $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'host' => $_ENV['MYSQL_HOST'],
        'driver' => $_ENV['MYSQL_DRIVER'],
    ], $configuration);

    return new EntityManager($connection, $configuration);
}
