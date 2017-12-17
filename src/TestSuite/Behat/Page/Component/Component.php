<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Component;

use Cake\Network\Exception\NotImplementedException;
use OurSociety\TestSuite\Behat\Page\Page;

abstract class Component extends Page
{
    protected function getPath(): string
    {
        throw new NotImplementedException('Component pages provide assertions but can not be directly opened');
    }
}
