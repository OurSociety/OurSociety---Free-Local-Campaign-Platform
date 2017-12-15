<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Guest;

use OurSociety\TestSuite\Behat\Page\Page;

/**
 * MunicipalProfilePage.
 */
class MunicipalProfile extends Page
{
    public function hasHeading(string $expectedHeading, ?string $expectedSubheading): bool
    {
        $headingElement = $this->find('css', 'h1.os-title');
        $subheadingElement = $headingElement->find('css', 'small');

        $actualSubheadingText = $subheadingElement->getText();
        $actualHeadingText = trim(str_replace($actualSubheadingText, '', $headingElement->getText()));

        if ($expectedSubheading !== null && strpos($actualSubheadingText, $expectedSubheading) === false) {
            return false;
        }

        return strpos($actualHeadingText, $expectedHeading) !== false;
    }

    public function hasMayor(string $name, string $email): bool
    {
        return false;
    }

    public function verifyPage()
    {
        $this->assertHeadingExists('Town information');
    }

    protected function getPath(): string
    {
        return '/municipality/{municipality}';
    }
}
