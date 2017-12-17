<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Element;

use OurSociety\TestSuite\Behat\Page\Traits\NodeElementAwareTrait;
use SensioLabs\Behat\PageObjectExtension\PageObject;

class Element extends PageObject\Element
{
    use NodeElementAwareTrait;

    public function waitUntilLastElementIsRemoved(): void
    {
        while ($this->find('xpath', $this->getXpath())) {
            usleep(100);
        }
    }
}
