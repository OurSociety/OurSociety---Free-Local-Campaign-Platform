<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * @Then /^I should see an? (error|success|warning) message$/
     * @Then /^I should see an? (error|success|warning) message that says "([^"]*)"$/
     */
    public function iShouldSeeAMessage(string $messageType, ?string $message = null): void
    {
        $class = '.alert-' . $messageType;
        $this->assertElementOnPage($class);
        if ($message !== null) {
            $this->assertElementContainsText($class, $message);
        }
    }
}
