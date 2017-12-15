<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;

class BrowserContext extends MinkContext implements Context
{
    public function fillField($field, $value): void
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $driver = $session->getDriver();

        $element = $page->findField($field);

        if ($element === null) {
            throw new ElementNotFoundException($driver, 'form field', 'id|name|label|value|placeholder', $field);
        }

        if ($element->getAttribute('type') === 'month' && $driver instanceof Selenium2Driver) {
            $element->focus();

            foreach (str_split($value) as $character) {
                if ($character === ' ') {
                    $driver->wait(10, null);
                    $character = "\t"; // TODO: Tab keypress not sent.
                }

                $element->keyPress($character);
            }
        }


        parent::fillField($field, $value);
    }
}
