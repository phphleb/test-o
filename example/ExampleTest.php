<?php

declare(strict_types=1);

namespace Phphleb\TestO\Example;

use Phphleb\TestO\TestCase;

/**
 * Sample class for tests.
 * The file name must end with 'Test.php'.
 * The class must be derived from TestCase.
 *
 * Пример класса для тестов.
 * Название файла должно заканчиваться на 'Test.php'.
 * Класс должен быть производным от TestCase.
 */
class ExampleTest extends TestCase
{
    /**
     * Optional method, executed before each test method.
     *
     * Необязательный метод, выполняется перед каждым тестовым методом.
     */
    #[\Override]
    public function setUp()
    {
        // ... //
    }

    /**
     * An example of calling a check for a positive boolean value.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример вызова проверки на положительное булево значение.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    public function testExampleFirstMethod(): void
    {
        $this->assertTrue(condition:true);
    }

    /**
     * An example of calling a test for a negative boolean value.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример вызова проверки на отрицательное булево значение.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    public function testExampleSecondMethod(): void
    {
        $this->assertFalse(condition:false);
    }

    /**
     * An example of a strict comparison of two arrays.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример строгой сверки двух массивов.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    public function testExampleThirdMethod(): void
    {
        $this->assertArrayEquals(expected: [], actual: []);
    }

    /**
     * Optional method, executed after each test method.
     *
     * Необязательный метод, выполняется после каждого тестового метода.
     */
    #[\Override]
    public function tearDown()
    {
        // ... //
    }
}