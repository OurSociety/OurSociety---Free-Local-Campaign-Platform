<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory as PageObjectFactory;

final class PageFactory
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var PageObjectFactory
     */
    private $pageObjectFactory;

    /**
     * @var Page\Page
     */
    private $currentPage;

    private function __construct(PageObjectFactory $pageObjectFactory)
    {
        $this->pageObjectFactory = $pageObjectFactory;
    }

    public static function instance(PageObjectFactory $pageObjectFactory): self
    {
        return self::$instance ?? self::$instance = new self($pageObjectFactory);
    }

    public function getPage($page): Page\Page
    {
        return $this->{sprintf('get%sPage', str_replace(' ', '', ucwords($page)))}();
    }

    public function getCurrentPage(): Page\Page
    {
        if ($this->currentPage === null) {
            $this->getRootPage()->open();
        }

        return $this->currentPage;
    }

    public function getAdminDashboardPage(): Page\Admin\Dashboard
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Admin\Dashboard::class);
    }

    public function getMyAccountPage(): Page\Common\MyAccount
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Common\MyAccount::class);
    }

    public function getAdminUsersListPage(): Page\Admin\ListUsersPage
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Admin\ListUsersPage::class);
    }

    public function getCitizenDashboardPage(): Page\Citizen\Dashboard
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Citizen\Dashboard::class);
    }

    public function getRepresentativeDashboardPage(): Page\Politician\Dashboard
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Politician\Dashboard::class);
    }

    public function getOnboardingPage(): Page\Citizen\Onboarding
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Citizen\Onboarding::class);
    }

    public function getCrudIndexPage(): Page\Crud\IndexPage
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Crud\IndexPage::class);
    }

    public function getForgotPasswordPage(): Page\Guest\ForgotPassword
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\ForgotPassword::class);
    }

    public function getHomePage(): Page\Guest\Home
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\Home::class);
    }

    public function getJoinPage(): Page\Guest\Join
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\Join::class);
    }

    public function getListingComponentPage(): Page\Component\Listing
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Component\Listing::class);
    }

    public function getMunicipalProfilePage(): Page\Guest\MunicipalProfile
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\MunicipalProfile::class);
    }

    public function getRepresentativeProfilePage(): Page\Guest\RepresentativeProfile
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\RepresentativeProfile::class);
    }

    public function getResetPasswordPage(): Page\Guest\ResetPassword
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\ResetPassword::class);
    }

    public function getRootPage(): Page\Guest\Root
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\Root::class);
    }

    public function getSignInPage(): Page\Guest\SignIn
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Guest\SignIn::class);
    }

    public function getRepresentativeProfileAwardListPage(): Page\Politician\Profile\AwardList
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Politician\Profile\AwardList::class);
    }

    public function getRepresentativeProfileEditVideoPage(): Page\Politician\Profile\EditVideo
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Politician\Profile\EditVideo::class);
    }

    public function getRepresentativeProfileVideoListPage(): Page\Politician\Profile\VideoList
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->currentPage = $this->pageObjectFactory->createPage(Page\Politician\Profile\VideoList::class);
    }
}
