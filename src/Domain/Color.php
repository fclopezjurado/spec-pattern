<?php

declare(strict_types=1);

namespace App\Domain;

enum Color: string
{
    case BLUE = 'blue';
    case GREEN = 'green';
    case YELLOW = 'yellow';
    case RED = 'red';
    case ORANGE = 'orange';
    case PURPLE = 'purple';
}
