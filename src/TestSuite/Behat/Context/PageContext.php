<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Behat\Mink\Exception\DriverException;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class PageContext extends PageObjectContext
{
    use Traits\CurrentPageAwareTrait;
    use Traits\FixturesTrait;

    /**
     * Throw exception.
     *
     * Throws a `Behat\Mink\Exception` so the `Behat\MinkExtension` `show_auto` setting can work.
     *
     * @param string $message
     * @return void
     * @throws DriverException
     */
    protected function throwException(string $message): void
    {
        throw new DriverException($message);
    }
}
