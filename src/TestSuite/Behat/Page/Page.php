<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Element\ElementInterface;
use Cake\Core\Configure;
use Cake\Routing\Router;
use OurSociety\TestSuite\Behat\Page\Element\Layout\{
    Flash, Navbar, NotificationMenu, UserMenu
};
use OurSociety\TestSuite\Behat\Page\Traits\NodeElementAwareTrait;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\{
    ElementNotFoundException, UnexpectedPageException
};
use SensioLabs\Behat\PageObjectExtension\PageObject\Page as BasePage;

abstract class Page extends BasePage
{
    use NodeElementAwareTrait;

    public function expireSession(): void
    {
        $this->getDriver()->setCookie('session_id');
    }

    public function getFlashStyle(): string
    {
        return $this->getFlash()->getStyle();
    }

    public function getFlashMessage(): string
    {
        return $this->getFlash()->getMessage();
    }

    public function signOut(): void
    {
        $this->getFlash()->close();
        $this->getUserMenu()->signOut();
    }

    public function clickNavbarLink(string $linkText): void
    {
        $this->getNavbar()->clickLink($linkText);
    }

    public function getUnreadNotificationCount(): int
    {
        return $this->getNotificationMenu()->getUnreadNotificationCount();
    }

    public function isLoadedUsingBrowserDriver(): bool
    {
        return $this->getDriver() instanceof Selenium2Driver;
    }

    public function hasHeading(string $expectedHeading, ?string $expectedSubheading = null): bool
    {
        if ($expectedSubheading !== null) {
            $headingElement = $this->find('css', 'h1.os-title');
            $subheadingElement = $headingElement->find('css', 'small');

            $actualSubheadingText = $subheadingElement->getText();
            $actualHeadingText = trim(str_replace($actualSubheadingText, '', $headingElement->getText()));

            if ($expectedSubheading !== null && strpos($actualSubheadingText, $expectedSubheading) === false) {
                return false;
            }

            return strpos($actualHeadingText, $expectedHeading) !== false;
        }

        foreach ($this->findAll('css', 'h1, h2, h3, h4, h5, h6') as $element) {
            /** @var ElementInterface $element */
            if (trim($element->getText()) === $expectedHeading) {
                return true;
            }
        }

        return false;
    }

    protected function assertFieldExists($locator): void
    {
        if (!$this->hasField($locator)) {
            throw new ElementNotFoundException(
                sprintf('%s page is missing "%s" field', $this->path, $locator)
            );
        }
    }

    protected function assertFieldValue($locator, $expected): void
    {
        $field = $this->findField($locator);
        if ($field === null) {
            $this->assertFieldExists($locator);
        }

        $value = $field->getValue();
        if ($value !== $expected) {
            throw new ElementNotFoundException(
                sprintf('%s field has incorrect value. Expected "%s", got "%s"', $field, $expected, $value)
            );
        }
    }

    protected function assertBreadcrumbsExist(array $breadcrumbs): void
    {
        foreach ($breadcrumbs as $breadcrumb) {
            $this->assertBreadcrumbExists($breadcrumb);
        }
    }

    protected function assertBreadcrumbExists($text): void
    {
        foreach ($this->findAll('css', '.breadcrumb .breadcrumb-item') as $element) {
            /** @var ElementInterface $element */
            if (trim($element->getText()) === $text) {
                return;
            }
        }

        throw new ElementNotFoundException(
            sprintf('Breadcrumb "%s" not found.', $text)
        );
    }

    protected function assertHeadingExists($heading): void
    {
        if ($this->hasHeading($heading) === false) {
            throw new ElementNotFoundException(
                sprintf('Heading "%s" not found.', $heading)
            );
        }
    }

    protected function assertHeadingsExist(array $headings): void
    {
        foreach ($headings as $heading) {
            $this->assertHeadingExists($heading);
        }
    }

    protected function assertRedirect(string $url): void
    {
        $expected = strpos($url, '/') === 0 ? $this->getParameter('base_url') . $url : $url;
        $actual = $this->getDriver()->getCurrentUrl();

        if ($actual !== $expected) {
            throw new UnexpectedPageException(
                sprintf('Expected to be redirected to "%s" but found "%s" instead', $expected, $actual)
            );
        }
    }

    protected function getUrl(array $urlParameters = null): string
    {
        Configure::write('App.fullBaseUrl', $this->getParameter('base_url'));

        return Router::url(['_name' => $this->getRouteName()] + ($urlParameters ?? []), true);
    }

    abstract protected function getRouteName(): string;

    private function getUserMenu(): UserMenu
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getElement(UserMenu::class);
    }

    private function getFlash(): Flash
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getElement(Flash::class);
    }

    private function getNavbar(): Navbar
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getElement(Navbar::class);
    }

    private function getNotificationMenu(): NotificationMenu
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getElement(NotificationMenu::class);
    }
}
