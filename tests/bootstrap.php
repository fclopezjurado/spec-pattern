<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use Throwable;

require_once __DIR__.'/../vendor/autoload.php';

function getEntityManager(): ?EntityManager
{
    $dotenv = Dotenv::createImmutable(__DIR__.'/../');

    $dotenv->load();

    $configurationOptions = Setup::createAttributeMetadataConfiguration(
        paths: [__DIR__.'/../src'],
        isDevMode: true,
    );
    $connectionParameters = [
        'dbname' => $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'host' => $_ENV['MYSQL_ROOT_HOST'],
        'driver' => $_ENV['MYSQL_DRIVER'],
    ];

    try {
        return EntityManager::create($connectionParameters, $configurationOptions);
    } catch (Throwable $exception) {
        var_dump($exception->getMessage());
    }

    return null;
}
