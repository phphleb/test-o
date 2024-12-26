<?php

/**
 * @author  Foma Tuturov <fomiash@yandex.ru>
 */

declare(strict_types=1);

namespace Phphleb\TestO;

use Phphleb\TestO\Tests\ArrayEqualsTest;

class TestCase
{
    private array $tests = [];

    /**
     * @internal
     */
    final public function _getTestResults(): array
    {
        return $this->tests;
    }

    /**
     * @internal
     */
    final public function _setExpectNextMethod(): void
    {
        $this->tests = [];
    }

    /**
     * Calling check for a positive value.
     *
     * Вызов проверки на положительное значение.
     *
     * @param bool $condition - the result of a fulfilled condition.
     *                        - результат выполненного условия.
     *
     * @param string $message - message to be output if the test is not successful.
     *                        - сообщение для вывода в случае если тест не успешен.
     */
    final public function assertTrue(bool $condition, string $message = ''): void
    {
        $this->tests[] = ['AssertTrueTest', $condition === true, $message];
    }

    /**
     * Calling a check for a negative value.
     * 
     * Вызов проверки на отрицательное значение.
     *
     * @param bool $condition - the result of a fulfilled condition.
     *                        - результат выполненного условия.
     *
     * @param string $message - message to be output if the test is not successful.
     *                        - сообщение для вывода в случае если тест не успешен.
     */
    final public function assertFalse(bool $condition, string $message = ''): void
    {
        $this->tests[] = ['AssertFalseTest', $condition === false, $message];
    }

    /**
     * Calls to compare two values for equality with strict type checking.
     *
     * Вызов сравнения двух значений на равенство со строгой проверкой типов.
     *
     * @param bool|string|int|float $expected - the first value being compared.
     *                                        - первое сравниваемое значение.
     *
     * @param bool|string|int|float $actual - second value being compared.
     *                                      - второе сравниваемое значение.
     *
     * @param string $message - message to be output if the test is not successful.
     *                        - сообщение для вывода в случае если тест не успешен.
     */
    final public function assertEquals(bool|string|int|float $expected, bool|string|int|float $actual, string $message = ''): void
    {
        $this->tests[] = ['AssertEqualsTest', $expected === $actual, $message];
    }

    /**
     * Call to compare two values for inequality with strict type checking.
     *
     * Вызов сравнения двух значений на неравенство со строгой проверкой типов.
     *
     * @param bool|string|int|float $expected - the first value being compared.
     *                                        - первое сравниваемое значение.
     *
     * @param bool|string|int|float $actual - second value being compared.
     *                                      - второе сравниваемое значение.
     *
     * @param string $message - message to be output if the test is not successful.
     *                        - сообщение для вывода в случае если тест не успешен.
     */
    final public function assertNotEquals(bool|string|int|float $expected, bool|string|int|float $actual, string $message = ''): void
    {
        $this->tests[] = ['AssertNotEqualsTest', $expected !== $actual, $message];
    }

    /**
     * Calling a check to compare the contents of two arrays.
     * In associative arrays, the order of the keys does not matter for comparison.
     *
     * Вызов проверки на сравнение содержимого двух массивов.
     * В ассоциативных массивах порядок ключей не имеет значения для сравнения.
     *
     * @param array $expected - the first array to be compared.
     *                        - первый сравниваемый массив.
     *
     * @param array $actual - the second array to compare.
     *                      - второй сравниваемый массив.
     *
     * @param string $message - message to be output if the test is not successful.
     *                        - сообщение для вывода в случае если тест не успешен.
     */
    final public function assertArrayEquals(array $expected, array $actual, string $message = ''): void
    {
        $this->tests[] = ['assertArrayEqualsTest', ArrayEqualsTest::check($expected, $actual), $message];
    }

    /**
     * Executed before each test method in the class.
     *
     * Выполняется до каждого тестового метода в классе.
     */
    public function setUp()
    {
    }

    /**
     * Executed after each test method in the class.
     *
     * Выполняется после каждого тестового метода в классе.
     */
    public function tearDown()
    {
    }
}
