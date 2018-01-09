<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use OurSociety\TestSuite\Behat\Context\PageContext;
use Psr\Log\LogLevel;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class GuestContext extends PageContext
{
    /**
     * @Given I am on the homepage
     */
    public function iAmOnTheHomepage()
    {
        $this->pages->getHomePage()->open();
    }

    /**
     * @Then I should see the heading :heading
     * @Then I should see the heading :heading with subheading :subheading
     */
    public function iShouldSeeTheHeading(string $heading, ?string $subheading = null)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        expect($this->pages->getCurrentPage())->toHaveHeading($heading, $subheading);
    }

    /**
     * @Then I should see the mayor :name with the email :email
     */
    public function iShouldSeeTheMayorWithTheEmail($name, $email)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        expect($this->pages->getCurrentPage())->toHaveMayor($name, $email);
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

    /**
     * @When I sign in with email :email and password :password
     */
    public function iSignInWithEmailAndPassword(string $email, string $password): void
    {
        $this->pages->getSignInPage()->signInAs($email, $password);
    }

    /**
     * @When I click to join OurSociety
     */
    public function clickToJoinOurSociety()
    {
        $this->pages->getSignInPage()->join();
    }

    /**
     * @When I click forgot password
     */
    public function iClickForgotPassword()
    {
        $this->pages->getSignInPage()->forgotPassword();
    }

    /**
     * @When my session expires
     */
    public function mySessionExpires()
    {
        $this->pages->getCitizenDashboardPage()->expireSession();
    }

    /**
     * @Given I visit the citizen dashboard
     */
    public function iVisitTheCitizenDashboard()
    {
        $this->pages->getCitizenDashboardPage()->open();
    }

    /**
     * @Given I leave keep me signed in checked
     */
    public function iLeaveKeepMeSignedInChecked()
    {
        $this->pages->getSignInPage()->keepMeSignedIn();
    }

    /**
     * @Given I uncheck keep me signed in
     */
    public function iUncheckKeepMeSignedIn()
    {
        $this->pages->getSignInPage()->doNotKeepMeSignedIn();
    }

    /**
     * @Given I should be redirected to the sign in page when I refresh
     */
    public function iShouldBeRedirectedToTheSignInPageWhenIRefresh()
    {
        try {
            $this->pages->getCitizenDashboardPage()->open();
        } catch (UnexpectedPageException $exception) {
            $this->pages->getSignInPage()->isOpen();
            $this->log('Redirected to sign in page as expected.', LogLevel::DEBUG, ['exception' => $exception]);
        }
    }

    /**
     * @When I join with name :name, email :email and password :password
     */
    public function iJoinWithNameEmailAndPassword($name, $email, $password)
    {
        $page = $this->pages->getJoinPage();
        $page->open();
        $page->signUp($name, $email, $password);
    }

    /**
     * @Then /^I should be redirected to the blog$/
     * @throws \Behat\Mink\Exception\DriverException
     */
    public function iShouldBeRedirectedToTheBlog()
    {
        $this->iShouldBeOnThePage('home');
    }
}
