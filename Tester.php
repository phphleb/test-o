<?php
/**
 * @author  Foma Tuturov <fomiash@yandex.ru>
 */

declare(strict_types=1);

namespace Phphleb\TestO;

use CallbackFilterIterator;
use ErrorException;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
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

    readonly private false|string $directory;

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
        $this->directory = realpath(__DIR__ . '/../../../') . DIRECTORY_SEPARATOR . trim($dir, '\\/.');
    }

    /**
     * Returns the test execution status with information about the process.
     *
     * Возвращает статус успешности проведённых тестов с выводом информации о процессе.
     *
     * @throws ErrorException
     */
    public function execute(): bool
    {
        if ($this->errors) {
            echo end($this->errors) . PHP_EOL;
            return false;
        }

        if (!$this->directory || !file_exists($this->directory)) {
            throw new ErrorException("The resource at `$this->directory` was not found.");
        }
        
        include __DIR__ . '/TestCase.php';
        include __DIR__ . '/Tests/ArrayEqualsTest.php';
        
        if (is_dir($this->directory)) {
            $files = new CallbackFilterIterator(
                new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($this->directory, FilesystemIterator::SKIP_DOTS)
                ),
                function (SplFileInfo $current) {
                    return $current->isFile();
                }
            );
        } else {
            $files = [$this->directory];
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

            foreach ($methods as $method) {
                if (str_starts_with($method, 'test')) {
                    $mt = microtime(true);
                    if (method_exists($testClass::class, 'setUp')) {
                        $testClass->setUp();
                    }
                    try {
                        $testClass->_setExpectNextMethod();
                        $testClass->$method();
                        $launches = $testClass->_getTestResults();
                        foreach ($launches as $item) {
                            $tests++;
                            $line++;
                            [$type, $launch] = $item;
                            if ($launch) {
                                echo $this->isL() ? $tests . ' OK ' . $testClass::class . ':' . $method . $this->t($mt) : '.';
                            } else {
                                echo $this->isL() ? $tests . ' FAILURE ' . $testClass::class . ':' . $method . $this->t($mt) : 'F';
                                $failures[] = ['type' => $type, 'class' => $testClass::class, 'method' => $method];
                            }
                            if ($line === self::PER_LINE) {
                                echo $this->isL() ? '' : " ($tests)" . PHP_EOL;
                                $line = 0;
                            }
                        }
                    } catch (Throwable $t) {
                        echo $this->isL() ? $tests . ' ERROR ' . $testClass::class . ':' . $method . $this->t($mt) : 'E';
                        $errors[] = $testClass::class . ':' . $method . PHP_EOL . $t->getMessage() . ' ' . $t->getTraceAsString();
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
}
