<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Element;

use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject;
use WebDriver\Exception\NoSuchElement;

class Element extends PageObject\Element
{
    public function waitUntilLastElementIsRemoved(): void
    {
        while ($this->find('xpath', $this->getXpath())) {
            usleep(100);
        }
    }

    protected function findByCss(string $locator): NodeElement
    {
        $element = $this->find('css', $locator);

        if ($element === null) {
            throw new NoSuchElement(sprintf('Could not find any elements with CSS locator "%s"', $locator));
        }

        return $element;
    }
}
