<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\System;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterFeatureScope;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Cake\Filesystem\File;

class EnvironmentContext implements Context
{
    private const ENV_FILE = ROOT . DS . '.env.test';
    private const ENV_FILE_TEMPLATE = ROOT . DS . '.env.test.default';

    /**
     * @BeforeFeature
     *
     * @param BeforeFeatureScope $scope
     */
    public function setEnvironment(BeforeFeatureScope $scope)
    {
        $envFileTemplate = new File(self::ENV_FILE_TEMPLATE);
        $envFileTemplate->copy(self::ENV_FILE);
    }

    /**
     * @AfterFeature
     *
     * @param AfterFeatureScope $scope
     */
    public function resetEnvironment(AfterFeatureScope $scope)
    {
        $envFile = new File(self::ENV_FILE);
        $envFile->delete();
    }
}
