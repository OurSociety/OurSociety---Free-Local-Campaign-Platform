<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use OurSociety\TestSuite\Behat\Context\PageContext;
use OurSociety\TestSuite\Behat\Context\Traits;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class GuestContext extends PageContext
{
    use Traits\CommonContextAwareTrait;

    protected $adminDashboard;

    protected $citizenDashboard;

    protected $forgotPassword;

    protected $homepage;

    protected $join;

    protected $municipalProfile;

    protected $onboarding;

    protected $politicianDashboard;

    protected $representativeProfile;

    protected $signIn;

    public function __construct(
        Page\Admin\Dashboard $adminDashboard,
        Page\Citizen\Dashboard $citizenDashboard,
        Page\Citizen\Onboarding $onboarding,
        Page\Guest\ForgotPassword $forgotPassword,
        Page\Guest\Home $homepage,
        Page\Guest\Join $join,
        Page\Guest\RepresentativeProfile $representativeProfile,
        Page\Guest\SignIn $signIn,
        Page\Guest\MunicipalProfile $municipalProfile,
        Page\Politician\Dashboard $politicianDashboard
    ) {
        $this->adminDashboard = $adminDashboard;
        $this->citizenDashboard = $citizenDashboard;
        $this->forgotPassword = $forgotPassword;
        $this->homepage = $homepage;
        $this->join = $join;
        $this->municipalProfile = $municipalProfile;
        $this->onboarding = $onboarding;
        $this->politicianDashboard = $politicianDashboard;
        $this->representativeProfile = $representativeProfile;
        $this->signIn = $signIn;
    }

    /**
     * @Given I am on the homepage
     */
    public function iAmOnTheHomepage()
    {
        $this->homepage->open();
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

    /**
     * @When I sign in with email :email and password :password
     */
    public function iSignInWithEmailAndPassword(string $email, string $password): void
    {
        $this->signIn->signInAs($email, $password);
    }

    ///**
    // * @Then I should be on the citizen dashboard
    // */
    //public function iShouldBeOnTheCitizenDashboard()
    //{
    //    $this->citizenDashboard->isOpen();
    //}
    //
    ///**
    // * @Then I should be on the politician dashboard
    // */
    //public function iShouldBeOnThePoliticianDashboard()
    //{
    //    $this->politicianDashboard->isOpen();
    //}
    //
    ///**
    // * @Then I should be on the admin dashboard
    // */
    //public function iShouldBeOnTheAdminDashboard()
    //{
    //    $this->adminDashboard->isOpen();
    //}
    //
    ///**
    // * @Then I should be on the onboarding page
    // */
    //public function iShouldBeOnTheOnboardingPage(): void
    //{
    //    $this->onboarding->isOpen();
    //}
    //
    ///**
    // * @Then I am on the join page
    // */
    //public function iAmOnTheJoinPage()
    //{
    //    $this->join->isOpen();
    //}

    /**
     * @When I click to join OurSociety
     */
    public function clickToJoinOurSociety()
    {
        $this->signIn->join();
    }

    /**
     * @When I click forgot password
     */
    public function iClickForgotPassword()
    {
        $this->signIn->forgotPassword();
    }

    /**
     * @Then I am on the forgot password page
     */
    public function iAmOnTheForgotPasswordPage()
    {
        $this->forgotPassword->isOpen();
    }

    /**
     * @When my session expires
     */
    public function mySessionExpires()
    {
        $this->citizenDashboard->expireSession();
    }

    /**
     * @Given I visit the citizen dashboard
     */
    public function iVisitTheCitizenDashboard()
    {
        $this->citizenDashboard->open();
    }

    /**
     * @Given I leave keep me signed in checked
     */
    public function iLeaveKeepMeSignedInChecked()
    {
        $this->signIn->keepMeSignedIn();
    }

    /**
     * @Given I uncheck keep me signed in
     */
    public function iUncheckKeepMeSignedIn()
    {
        $this->signIn->doNotKeepMeSignedIn();
    }

    /**
     * @Given I should be redirected to the sign in page when I refresh
     */
    public function iShouldBeRedirectedToTheSignInPageWhenIRefresh()
    {
        try {
            $this->citizenDashboard->open();
        } catch (UnexpectedPageException $exception) {
            $this->signIn->isOpen();
        }
    }

    /**
     * @When I sign up with name :name, email :email and password :password
     */
    public function iSignUpWithNameEmailAndPassword($name, $email, $password)
    {
        $this->join->open();
        $this->join->signUp($name, $email, $password);
    }

    /**
     * @Then /^I should be redirected to the blog$/
     * @throws \Behat\Mink\Exception\DriverException
     */
    public function iShouldBeRedirectedToTheBlog()
    {
        $this->getCommonContext()->iShouldBeOnThePage('home');
    }
}
