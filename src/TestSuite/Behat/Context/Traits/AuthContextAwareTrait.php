<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use OurSociety\TestSuite\Behat\Context\System\AuthContext;

trait AuthContextAwareTrait
{
    /**
     * @var AuthContext
     */
    private $authContext;

    /** @BeforeScenario */
    public function setAuthContext(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();

        $this->authContext = $environment->getContext(AuthContext::class);
    }

    protected function getAuthContext(): AuthContext
    {
        return $this->authContext;
    }
}
