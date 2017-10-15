<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\System;

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Tester\Result\TestResult;

class DebugContext extends RawMinkContext
{
    /**
     * @AfterStep
     *
     * @param AfterStepScope $scope
     */
    public function waitToDebugInBrowserOnStepErrorHook(AfterStepScope $scope)
    {
        if ($scope->getTestResult()->getResultCode() === TestResult::FAILED) {
            echo PHP_EOL . 'PAUSING ON FAIL' . PHP_EOL;
            $this->getSession()->wait(10000000000);
        }
    }
}
