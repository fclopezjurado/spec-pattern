<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/src/bootstrap.php';

if (isset($entityManager)) {
    return ConsoleRunner::createHelperSet(entityManager: $entityManager);
}
