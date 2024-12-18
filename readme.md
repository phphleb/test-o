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
......

Time: 00:00:00, Memory: 0.51 MB

OK Tests: 6, Assertions: 6

```

Running tests in a different visual mode:
 ```bash
php ./vendor/phphleb/test-o/run -L ./vendor/phphleb/test-o/example
 ```
Tests will be performed:
```text
Test-O 0.0.0 by Foma Tuturov.

Runtime:       PHP 8.2.7
1 OK Phphleb\TestO\Example\ExampleTest:testExampleFirstMethod (0.096ms)
2 OK Phphleb\TestO\Example\ExampleTest:testExampleSecondMethod (0.058ms)
3 OK Phphleb\TestO\Example\ExampleTest:testExampleThirdMethod (0.096ms)
4 OK Phphleb\TestO\Example\ExampleTest:testExampleDataProvider provider case 1  (0.086ms)
5 OK Phphleb\TestO\Example\ExampleTest:testExampleDataProvider provider case 2  (0.033ms)
6 OK Phphleb\TestO\Example\ExampleTest:testExampleDataProvider provider case 3  (0.021ms)


Time: 00:00:00, Memory: 0.51 MB

OK Tests: 6, Assertions: 6

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
