Primitive Unit Tests `Test-o`
=====================

![PHP](https://img.shields.io/badge/PHP-^8.2-blue) [![License: MIT](https://img.shields.io/badge/License-MIT%20(Free)-brightgreen.svg)](https://github.com/phphleb/hleb/blob/master/LICENSE)

_____________________

 Install using Composer:
 ```bash
composer require phphleb/test-o
 ```

An example check is in the "example" folder.

To run tests (methods starting with "test") for all files (classes)
(ending with "Test.php" and inherited from "Phphleb\TestO\TestCase") in a folder:

 ```bash
php ./vendor/phphleb/test-o/run ./vendor/phphleb/test-o/example
 ```
Tests will be performed:
```text
Test-O 0.0.0 by Foma Tuturov.

Runtime:       PHP 8.2.7
........

Time: 00:00:00, Memory: 0.52 MB

OK Tests: 8, Assertions: 8


```

Running tests in a different visual mode:
 ```bash
php ./vendor/phphleb/test-o/run -L ./vendor/phphleb/test-o/example
 ```
Tests will be performed:
```text
Test-O 0.0.0 by Foma Tuturov.

Runtime:       PHP 8.2.7
1 OK Phphleb\TestO\Example\ExampleTest:testExampleFirstMethod (0.109ms)
2 OK Phphleb\TestO\Example\ExampleTest:testExampleSecondMethod (0.066ms)
3 OK Phphleb\TestO\Example\ExampleTest:testExampleThirdMethod (0.084ms)
4 OK Phphleb\TestO\Example\ExampleTest:testExampleFourthMethod (0.054ms)
5 OK Phphleb\TestO\Example\ExampleTest:testExampleFifthMethod (0.038ms)
6 OK Phphleb\TestO\Example\ExampleTest:testExampleDataProvider provider case 1  (0.037ms)
7 OK Phphleb\TestO\Example\ExampleTest:testExampleDataProvider provider case 2  (0.022ms)
8 OK Phphleb\TestO\Example\ExampleTest:testExampleDataProvider provider case 3  (0.031ms)


Time: 00:00:00, Memory: 0.52 MB

OK Tests: 8, Assertions: 8


```

To run tests on a single file (class):

 ```bash
php ./vendor/phphleb/test-o/run ./vendor/phphleb/test-o/example/ExampleTest.php
 ```

To run tests on a single file (class) and method:

 ```bash
php ./vendor/phphleb/test-o/run ./vendor/phphleb/test-o/example/ExampleTest.php:testExampleFirstMethod
 ```

If tests are used for the [HLEB2](https://github.com/phphleb/hleb) framework:

 ```bash
composer require phphleb/tests
 ```
 ```bash
php ./vendor/phphleb/test-o/run ./vendor/phphleb/tests
 ```
