<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);

$dotenv->load();

$configurationOptions = Setup::createAttributeMetadataConfiguration(
    paths: [__DIR__.'/src'],
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
    $entityManager = EntityManager::create($connectionParameters, $configurationOptions);
} catch (Throwable $exception) {
    var_dump($exception->getMessage());
    exit;
}
