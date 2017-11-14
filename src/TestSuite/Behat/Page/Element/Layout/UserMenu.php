<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Element\Layout;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class UserMenu extends Element
{
    protected $selector = '#userMenu';

    public function signOut(): void
    {
        $this->click();
        $this->clickLink('Sign Out');
    }
}
