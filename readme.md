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

Runtime:       PHP 8.2.3
...

Time: 00:00:00, Memory: 3.5 MB

OK Tests: 3, Assertions: 3

```

Running tests in a different visual mode:
 ```bash
php ./vendor/phphleb/test-o/run -L ./vendor/phphleb/test-o/example
 ```
Tests will be performed:
```text
Test-O 0.0.0 by Foma Tuturov.

Runtime:       PHP 8.2.3
1 OK Phphleb\TestO\Example\ExampleTest:testExampleFirstMethod (0.007ms)
2 OK Phphleb\TestO\Example\ExampleTest:testExampleSecondMethod (0.003ms)
3 OK Phphleb\TestO\Example\ExampleTest:testExampleThirdMethod (0.007ms)


Time: 00:00:00, Memory: 5.23 MB

OK Tests: 3, Assertions: 3


```

To run tests on a single file (class):

 ```bash
php ./vendor/phphleb/test-o/run ./vendor/phphleb/test-o/example/ExampleTest.php
 ```

If tests are used for the [HLEB](https://github.com/phphleb/hleb) framework:

 ```bash
composer require phphleb/tests
 ```
 ```bash
php ./vendor/phphleb/test-o/run ./vendor/phphleb/tests
 ```
