<?php
/**
 * @author  Foma Tuturov <fomiash@yandex.ru>
 */

declare(strict_types=1);

namespace Phphleb\TestO;

use CallbackFilterIterator;
use ErrorException;
use FilesystemIterator;
use Phphleb\TestO\Tests\DataProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use ReflectionMethod;
use SplFileInfo;
use Throwable;

class Tester
{
    private const PER_LINE = 50;

    private const P5T_MODE = 0;

    private const C9N_MODE = 1;

    private const HELP = 'HELP: php <path> <directory|[-l|--list]> [directory]' . PHP_EOL .
    '   Example: php ./vendor/phphleb/test-o/run ./vendor/phphleb/test-o/example' . PHP_EOL .
    '   or php ./vendor/phphleb/test-o/run -l ./vendor/phphleb/test-o/example';

    private array $errors = [];

    private false|string $directoryOrFile;

    private null|string $method = null;

    readonly private int $mode;

    public function __construct(string $argA, ?string $argB = null)
    {
        $dir = $argA;
        if ($argB !== null) {
            if (in_array($argA, ['-l', '-L', '--list', '--List', '--LIST', '-LIST', '-List', '-list'])) {
                $this->mode = self::C9N_MODE;
                $dir = $argB;
            } else {
                $this->errors[] = self::HELP;
            }
        } else {
            $this->mode = self::P5T_MODE;
        }
        $this->directoryOrFile = realpath(__DIR__ . '/../../../') . DIRECTORY_SEPARATOR . trim($dir, '\\/.');
    }

    /**
     * Returns the test execution status with information about the process.
     *
     * Возвращает статус успешности проведённых тестов с выводом информации о процессе.
     *
     * @throws ErrorException|ReflectionException
     */
    public function execute(): bool
    {
        if ($this->errors) {
            echo end($this->errors) . PHP_EOL;
            return false;
        }
        $files = [];

        include __DIR__ . '/TestCase.php';
        include __DIR__ . '/Tests/ArrayEqualsTest.php';

        if ($this->directoryOrFile) {
            if (is_dir($this->directoryOrFile)) {
                $files = new CallbackFilterIterator(
                    new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($this->directoryOrFile, FilesystemIterator::SKIP_DOTS)
                    ),
                    function (SplFileInfo $current) {
                        return $current->isFile();
                    }
                );
            } else {
                if (str_contains($this->directoryOrFile, '.php:')) {
                    $parts = explode('.php:', $this->directoryOrFile, 2);
                    [$this->directoryOrFile, $this->method] = $parts;
                    $this->directoryOrFile .= '.php';
                }
                $files = [$this->directoryOrFile];
            }

            if (!file_exists($this->directoryOrFile)) {
                throw new ErrorException("The resource at `$this->directoryOrFile` was not found.");
            }
        }


        $tests = [];
        foreach ($files as $file) {
            if (str_ends_with((string)$file, 'Test.php')) {
                include((string)$file);
                $classes = get_declared_classes();
                $class = new (end($classes));
                if (!is_a($class, TestCase::class)) {
                    $name = $class::class;
                    throw new ErrorException("The $name class must be inherited from the Phphleb\TestO\TestCase class.");
                }
                $tests[] = $class;
            }
        }

        return $this->test($tests);
    }

    /**
     * Handling one class with tests.
     *
     * Обработка одного класса с тестами.
     *
     * @param TestCase[] $testClass
     *
     * @throws ReflectionException
     */
    private function test(array $testClasses): bool
    {
        echo 'Test-O 0.0.0 by Foma Tuturov.' . PHP_EOL . PHP_EOL;
        echo 'Runtime:       PHP ' . PHP_VERSION . PHP_EOL;

        $start = time();
        $tests = 0;
        $failures = [];
        $errors = [];
        $line = 0;
        /** @var TestCase $testClass */
        foreach ($testClasses as $testClass) {
            $methods = get_class_methods($testClass);
            if (!class_exists(DataProvider::class, false)) {
                require __DIR__ . '/Tests/DataProvider.php';
            }
            foreach ($methods as $method) {
                if ($this->method && $this->method !== $method) {
                    continue;
                }
                if (str_starts_with($method, 'test')) {
                    $mt = microtime(true);
                    $reflectionMethod = new ReflectionMethod($testClass::class, $method);
                    if ($attributes = $reflectionMethod->getAttributes(DataProvider::class)) {
                        $functionName = current($attributes)->newInstance()->functionName;
                        foreach ($testClass->$functionName() as $key => $values) {
                            $mt = microtime(true);
                            $function = function () use ($testClass, $method, $values) {
                                $testClass->$method(...$values);
                            };
                            $this->executeTests($function, $testClass, $method, $mt, $tests, $line, $errors, $failures, (string)$key);
                        }
                    } else {
                        $function = function () use ($testClass, $method) {
                            $testClass->$method();
                        };
                        $this->executeTests($function, $testClass, $method, $mt, $tests, $line, $errors, $failures);
                    }
                }
            }
        }
        $info = 'Tests: ' . $tests;
        echo PHP_EOL . PHP_EOL . 'Time: ' . gmdate('H:i:s', (time() - $start)) . ', ';
        echo 'Memory: ' . round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL . PHP_EOL;

        if (count($failures)) {
            echo 'Failures: ' . count($failures) . PHP_EOL;
            foreach ($failures as $key => $failure) {
                echo ($key + 1) . ') ' . $failure['type'] . ' failure in ' . $failure['class'] . ':' . $failure['method'] . PHP_EOL;
            }
            echo PHP_EOL . PHP_EOL;
            $info .= ', Failures: ' . count($failures);
        }

        if (count($errors)) {
            echo 'Errors: ' . count($errors) . PHP_EOL;
            foreach ($errors as $key => $error) {
                echo PHP_EOL . ($key + 1) . ') ' . $error . PHP_EOL . '(!) If a method has an error, subsequent checks in that method may not run.' . PHP_EOL;
            }
            echo PHP_EOL . PHP_EOL;
            $info .= ', Errors: ' . count($errors);
        }

        $assertions = $tests - count($failures) - count($errors);
        $info .= ', Assertions: ' . ($tests - count($failures) - count($errors)) . PHP_EOL;
        $status = $assertions === $tests;
        echo ($status ? 'OK ' : 'FAILURES!' . PHP_EOL) . $info . PHP_EOL;

        return $status;
    }

    private function isL(): bool
    {
        return $this->mode === self::C9N_MODE;
    }

    private function t(float $time): string
    {
        $name = 'ms';
        $t = number_format((microtime(true) - $time) * 1000, 3, ".", "");
        if ($t > 1000) {
            $t = number_format($t / 1000, 2, ".", "");
            $name = 's';
        }
        return " ({$t}{$name})" . PHP_EOL;
    }

    public function executeTests(
        callable $function,
        TestCase $testClass,
        string   $method,
        float    $mt,
        int      &$tests,
        int      &$line,
        array    &$errors,
        array    &$failures,
        string   $key = '',
    ): void {
        if (method_exists($testClass::class, 'setUp')) {
            $testClass->setUp();
        }
        try {
            $testClass->_setExpectNextMethod();
            $function();
            $launches = $testClass->_getTestResults();
            $key = $key ? " {$key} " : '';
            foreach ($launches as $item) {
                $tests++;
                $line++;
                [$type, $launch] = $item;
                if ($launch) {
                    echo $this->isL() ? $tests . ' OK ' . $testClass::class . ':' . $method . $key . $this->t($mt) : '.';
                } else {
                    echo $this->isL() ? $tests . ' FAILURE ' . $testClass::class . ':' . $method . $key . $this->t($mt) : 'F';
                    $failures[] = ['type' => $type, 'class' => $testClass::class, 'method' => $method];
                }
                if ($line === self::PER_LINE) {
                    echo $this->isL() ? '' : " ($tests)" . PHP_EOL;
                    $line = 0;
                }
            }
        } catch (Throwable $t) {
            echo $this->isL() ? $tests . ' ERROR ' . $testClass::class . ':' . $method . $key . $this->t($mt) : 'E';
            $errors[] = $testClass::class . ':' . $method . $key . PHP_EOL . $t->getMessage() . ' ' . $t->getTraceAsString();
            $tests++;
            $line++;
        }
        if ($line === self::PER_LINE) {
            echo $this->isL() ? '' : " ($tests)" . PHP_EOL;
            $line = 0;
        }
        if (method_exists($testClass::class, 'tearDown')) {
            $testClass->tearDown();
        }
    }
}
