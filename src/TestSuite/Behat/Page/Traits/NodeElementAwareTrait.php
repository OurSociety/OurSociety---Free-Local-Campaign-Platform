<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Traits;

use Behat\Mink\Element\NodeElement;
use WebDriver\Exception\NoSuchElement;

trait NodeElementAwareTrait
{
    protected function findByCss(string $locator): NodeElement
    {
        $element = $this->find('css', $locator);

        if ($element === null) {
            throw new NoSuchElement(sprintf('Could not find any elements with CSS locator "%s"', $locator));
        }

        return $element;
    }
}
