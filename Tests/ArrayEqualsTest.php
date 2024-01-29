<?php

/**
 * @author  Foma Tuturov <fomiash@yandex.ru>
 */

namespace Phphleb\TestO\Tests;

/**
 * Internal class for array comparison.
 *
 * Служебный класс для сравнения массивов.
 *
 * @internal
 */
final class ArrayEqualsTest
{
    /**
     * Returns the result of a strict array comparison.
     * In associative arrays, the order of the keys does not matter.
     *
     * Возвращает результат строгого сравнения массивов.
     * В ассоциативных массивах порядок ключей не имеет значения.
     */
    public static function check(array $expected, array $actual): bool
    {
        if (self::isAssoc($expected) !== self::isAssoc($actual)) {
            return false;
        }
        return self::compare($expected, $actual) && self::compare($actual, $expected);
    }

    /**
     * Comparing arrays according to the first.
     *
     * Сравнение массивов согласно начальному.
     */
    private static function compare(array $first, array $second): bool
    {
        foreach ($first as $key => $value) {
            if (!array_key_exists($key, $second) || gettype($value) !== gettype($second[$key])) {
                return false;
            }
            $sKey = $second[$key];
            if (is_array($value)) {
                if (self::isAssoc($value) !== self::isAssoc($sKey) || !self::compare($value, $sKey)) {
                    return false;
                }
            } else if (is_null($value)) {
                if (!is_null($sKey)) {
                    return false;
                }
            } else if ($value !== $sKey) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checking if an array is associative.
     *
     * Проверка, что массив ассоциативный.
     */
    private static function isAssoc(array $array): bool
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }
}