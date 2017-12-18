<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Citizen;

use OurSociety\TestSuite\Behat\Page\Page;

class Onboarding extends Page
{
    public function doTutorial()
    {
        $totalScreens = 5;
        for ($currentScreen = 1; $currentScreen < $totalScreens; $currentScreen++) {
            $this->clickLink(sprintf('tutorial-%d-continue', $currentScreen));
        }
    }

    protected function getRouteName(): string
    {
        return 'users:onboarding';
    }
}
