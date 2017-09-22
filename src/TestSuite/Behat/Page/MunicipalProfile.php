<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

/**
 * MunicipalProfilePage.
 */
class MunicipalProfile extends Page
{
    protected function getPath(): string
    {
        return '/municipality/{municipality}';
    }

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
        $this->assertHeaderExists('Town information');
    }
}
