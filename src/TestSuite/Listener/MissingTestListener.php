<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Listener;

use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Test;

class MissingTestListener extends BaseTestListener
{
    /**
     * @var array
     */
    private $skipMethods;

    /**
     * @var array
     */
    private $tests = [];

    public function __construct(array $skipMethods = [])
    {
        $this->skipMethods = $skipMethods;
    }

    /**
     * @param Test|TestCase $test
     * @param float $time
     */
    public function endTest(Test $test, $time): void
    {
        $class = get_class($test);
        $name = $test->getName(false);

        if (!array_key_exists($class, $this->tests)) {
            $this->tests[$class] = [];
        }

        if (!in_array($name, $this->tests[$class], true)) {
            $this->tests[$class][] = $name;
        }
    }

    public function endTestSuite(TestSuite $suite): void
    {
        foreach ($this->tests as $testClass => $actualTestMethods) {
            $subjectClass = str_replace(['Test\\TestCase\\', 'Test'], '', $testClass);
            $subject = new \ReflectionClass($subjectClass);

            $expectedTestMethods = [];
            foreach ($subject->getMethods(\ReflectionMethod::IS_PUBLIC) as $subjectMethod) {
                if ($subjectMethod->getDeclaringClass()->getName() === $subjectClass) {
                    if (!in_array($subjectMethod->getName(), $this->skipMethods, true)) {
                        $expectedTestMethods[] = sprintf('test%s', ucfirst($subjectMethod->getName()));
                    }
                }
            }

            $missingTestMethods = array_diff($expectedTestMethods, $actualTestMethods);

            if (count($missingTestMethods) > 0) {
                d(sprintf('Class "%s" is missing test methods "%s"', $testClass, implode('", "', $missingTestMethods)));
            }
        }
    }
}
