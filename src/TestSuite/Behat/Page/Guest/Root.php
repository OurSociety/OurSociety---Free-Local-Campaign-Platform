<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

class Root extends Page
{
    protected function getRouteName(): string
    {
        return 'root';
    }

    protected function verifyUrl(array $urlParameters = []): void
    {
        $this->assertHeadingsExist([
            'Join OurSociety',
            'Our Purpose',
            'The OurSociety Experiment',
        ]);
    }
}
