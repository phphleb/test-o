<?php

declare(strict_types=1);

namespace Phphleb\TestO\Example;

use Phphleb\TestO\TestCase;
use Phphleb\TestO\Tests\DataProvider;

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
     * In associative arrays, the order of the keys
     * does not matter for comparison.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример строгой сверки двух массивов.
     * В ассоциативных массивах порядок ключей
     * не имеет значения для сравнения.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    public function testExampleThirdMethod(): void
    {
        $this->assertArrayEquals(expected: [], actual: []);
    }

    /**
     * An example of a strict test for inequality of two values.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример строгой проверки на неравенство двух значений.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    public function testExampleFourthMethod(): void
    {
        $this->assertNotEquals(2 + 2, 5);
    }

    /**
     * An example of a strict test for equality of two values.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример строгой проверки на равенство двух значений.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    public function testExampleFifthMethod(): void
    {
        $this->assertEquals(2 + 2, 4);
    }

    /**
     * An example of complex processing of similar tests using a data provider.
     * In this case, a function is assigned through the DataProvider attribute,
     * whose data is passed to the method as arguments.
     * For testing purposes, the method name must begin with 'test'.
     *
     * Пример комплексной обработки схожих тестов при помощи провайдера данных.
     * В данном случае через атрибут DataProvider назначается функция,
     * данные которой передаются в метод как аргументы.
     * Для тестирования, название метода должно начинаться с 'test'.
     */
    #[DataProvider('exampleProvider')]
    public function testExampleDataProvider(int $a, int $b, int $expected): void
    {
        $this->assertEquals($a + $b, $expected);
    }

    /**
     * Test data set for DataProvider.
     * Each position will be performed as a separate test.
     *
     * Набор тестовых данных для DataProvider.
     * Каждая позиция будет выполнена как отдельный тест.
     */
    public function exampleProvider(): iterable
    {
        return [
        'provider case 1' => [1, 2, 3],
        'provider case 2' => [2, 3, 5],
        'provider case 3' => [3, 5, 8],
    ];
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
