# Spec pattern kata
Development to implement specification pattern in infrastructure repositories. We used these links as reference for 
implementation

https://github.com/CodelyTV/php-ddd-example/blob/main/src/Shared/Domain/Criteria/Filters.php

https://www.ultimatespecs.com/car-specs/Acura/123872/Acura-TLX-2021-.html

https://www.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/getting-started.html

https://lamp-dev.com/using-doctrine-orm-without-symfony-framework/1779

## Setup & run

### 1. Run these commands

```shell
make ENV_FILE=.env up
make ENV_FILE=.env dependencies
make ENV_FILE=.env create-database
```

Don't forget to add the environment file to use to run the command.

### 2. Run integration tests

```shell
make ENV_FILE=.env.test integration-test
```

We specified .env.test as environment file for testing.