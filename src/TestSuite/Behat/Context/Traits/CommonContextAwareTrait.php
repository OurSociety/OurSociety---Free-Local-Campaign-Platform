<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use OurSociety\TestSuite\Behat\Context\Page\CommonContext;

trait CommonContextAwareTrait
{
    /**
     * @var CommonContext
     */
    private $commonContext;

    /** @BeforeScenario */
    public function setCommonContext(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();

        $this->commonContext = $environment->getContext(CommonContext::class);
    }

    protected function getCommonContext(): CommonContext
    {
        return $this->commonContext;
    }
}
