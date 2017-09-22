<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
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
     * @Given I am on the :name municipal profile
     */
    public function iAmOnTheMunicipalProfile($municipality)
    {
        $this->municipalProfile->open([
            'municipality' => (new CakeSlugger)->slug($municipality),
        ]);
    }

    /**
     * @Then I should see the heading :heading
     * @Then I should see the heading :heading with subheading :subheading
     */
    public function iShouldSeeTheHeadingWithSubheading(string $heading, ?string $subheading = null)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        expect($this->municipalProfile)->toHaveHeading($heading, $subheading);
    }

    /**
     * @Then I should see the mayor :name with the email :email
     */
    public function iShouldSeeTheMayorWithTheEmail($name, $email)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        expect($this->municipalProfile)->toHaveMayor($name, $email);
    }

    /**
     * @Then I should see town information containing :text
     */
    public function iShouldSeeTownInformationContaining($text)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a map
     */
    public function iShouldSeeAMap()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see the following statistics:
     */
    public function iShouldSeeTheFollowingStatistics(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see the following articles:
     */
    public function iShouldSeeTheFollowingArticles(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given I should see a :label button that links to :url
     */
    public function iShouldSeeAButtonThatLinksTo($arg1, $arg2)
    {
        throw new PendingException();
    }
}
