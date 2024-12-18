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
     */
    final public function assertTrue(bool $condition): void
    {
        $this->tests[] = ['AssertTrueTest', $condition === true];
    }

    /**
     * Calling a check for a negative value.
     * 
     * Вызов проверки на отрицательное значение.
     */
    final public function assertFalse(bool $condition): void
    {
        $this->tests[] = ['AssertFalseTest', $condition === false];
    }

    /**
     * Calls comparison of two values with strict type checking.
     *
     * Вызов сравнения двух значений со строгой проверкой типов.
     */
    final public function assertEquals(bool|string|int|float $expected, bool|string|int|float $actual): void
    {
        $this->tests[] = ['AssertEqualsTest', $expected === $actual];
    }

    /**
     * Calling a check to compare the contents of two arrays.
     * In associative arrays, the order of the keys does not matter.
     *
     * Вызов проверки на сравнение содержимого двух массивов.
     * В ассоциативных массивах порядок ключей не имеет значения.
     */
    final public function assertArrayEquals(array $expected, array $actual): void
    {
        $this->tests[] = ['assertArrayEqualsTest', ArrayEqualsTest::check($expected, $actual)];
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
