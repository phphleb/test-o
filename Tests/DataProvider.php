<?php

declare(strict_types=1);

namespace Phphleb\TestO\Tests;

/**
 * An attribute for connecting a specific function with a method
 * into which data will be submitted.
 *
 * Атрибут для связи определенной функции с методом
 * в который будут поданы данные.
 *
 * @see ExampleTest::testExampleDataProvider()
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class DataProvider
{
    /**
     * The name of the function from which the data is taken.
     * This data will be fed iteratively as method arguments as separate tests.
     *
     * Название функции из которой берутся данные.
     * Эти данные будут поданы итерационно в качестве аргументов метода как отдельные тесты.
     *
     * @see ExampleTest::exampleProvider()
     */
    public function __construct(public string $functionName){}
}
