<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

/**
 * MunicipalProfilePage.
 */
class MunicipalProfile extends Page
{
    protected $path = '/municipality/{municipality}';

    public function verifyPage()
    {
        $this->assertHeaderExists('Town information');
    }
}
