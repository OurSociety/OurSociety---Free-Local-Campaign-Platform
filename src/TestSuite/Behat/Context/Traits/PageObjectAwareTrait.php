<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory as PageObjectFactory;

trait PageObjectAwareTrait
{
    /**
     * @var PageObjectFactory
     */
    private $pageObjectFactory;

    /**
     * @param PageObjectFactory $pageObjectFactory
     *
     * @return null
     */
    public function setPageObjectFactory(PageObjectFactory $pageObjectFactory): void
    {
        $this->pageObjectFactory = $pageObjectFactory;
    }

    protected function getAdminDashboardPage(): Page\Admin\Dashboard
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Admin\Dashboard::class);
    }

    protected function getAdminUsersListPage(): Page\Admin\ListUsersPage
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Admin\ListUsersPage::class);
    }

    protected function getCitizenDashboardPage(): Page\Citizen\Dashboard
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Citizen\Dashboard::class);
    }

    protected function getOnboardingPage(): Page\Citizen\Onboarding
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Citizen\Onboarding::class);
    }

    protected function getCrudIndexPage(): Page\Crud\IndexPage
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Crud\IndexPage::class);
    }

    protected function getForgotPasswordPage(): Page\Guest\ForgotPassword
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\ForgotPassword::class);
    }

    protected function getHomePage(): Page\Guest\Home
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\Home::class);
    }

    protected function getJoinPage(): Page\Guest\Join
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\Join::class);
    }

    protected function getListingComponentPage(): Page\Component\Listing
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Component\Listing::class);
    }

    protected function getMunicipalProfilePage(): Page\Guest\MunicipalProfile
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\MunicipalProfile::class);
    }

    protected function getRepresentativeProfilePage(): Page\Guest\RepresentativeProfile
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\RepresentativeProfile::class);
    }

    protected function getResetPasswordPage(): Page\Guest\ResetPassword
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\ResetPassword::class);
    }

    protected function getRootPage(): Page\Guest\Root
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\Root::class);
    }

    protected function getSignInPage(): Page\Guest\SignIn
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Guest\SignIn::class);
    }

    protected function getRepresentativeProfileAwardListPage(): Page\Politician\Profile\AwardList
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Politician\Profile\AwardList::class);
    }

    protected function getRepresentativeProfileEditVideoPage(): Page\Politician\Profile\EditVideo
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Politician\Profile\EditVideo::class);
    }

    protected function getRepresentativeProfileVideoListPage(): Page\Politician\Profile\VideoList
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->pageObjectFactory->createPage(Page\Politician\Profile\VideoList::class);
    }
}
