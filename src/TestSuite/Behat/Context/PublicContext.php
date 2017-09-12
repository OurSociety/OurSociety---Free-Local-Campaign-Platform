<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Muffin\Slug\Slugger\CakeSlugger;
use OurSociety\TestSuite\Behat\Page\MunicipalProfile;

class PublicContext extends PageContext
{
    /**
     * @var MunicipalProfile
     */
    private $municipalProfile;

    public function __construct(
        MunicipalProfile $municipalProfile
    ) {
        $this->municipalProfile = $municipalProfile;
    }

    /**
     * @Given /^I am on the "([^"]*)" municipal profile$/
     */
    public function iAmOnTheMunicipalProfile($municipality)
    {
        $this->municipalProfile->open([
            'municipality' => (new CakeSlugger)->slug($municipality),
        ]);
    }
}
