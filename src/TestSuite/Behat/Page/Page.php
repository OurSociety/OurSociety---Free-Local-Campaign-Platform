<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use Behat\Mink\Element\ElementInterface;
use OurSociety\TestSuite\Behat\Page\Element\Layout\Flash;
use OurSociety\TestSuite\Behat\Page\Element\Layout\UserMenu;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page as BasePage;

abstract class Page extends BasePage
{
    public function expireSession(): void
    {
        $this->getDriver()->setCookie('session_id', null);
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

    protected function assertFieldExists($locator): void
    {
        if (!$this->hasField($locator)) {
            throw new ElementNotFoundException(sprintf('%s page is missing "%s" field', $this->path, $locator));
        }
    }

    protected function assertFieldValue($locator, $expected): void
    {
        $field = $this->findField($locator);
        $value = $field->getValue();

        if ($value !== $expected) {
            throw new ElementNotFoundException(sprintf(
                '%s field has incorrect value. Expected "%s", got "%s"',
                $field,
                $expected,
                $value
            ));
        }
    }

    protected function assertHeaderExists($text): void
    {
        foreach ($this->findAll('css', 'h5') as $element) {
            /** @var ElementInterface $element */
            if ($element->getText() === $text) {
                return;
            }
        }

        throw new ElementNotFoundException(sprintf('Header "%s" not found.', $text));
    }

    protected function assertRedirect(string $url): void
    {
        $expected = $this->getParameter('base_url') . $url;
        $actual = $this->getDriver()->getCurrentUrl();

        if ($actual !== $expected) {
            throw new UnexpectedPageException(sprintf('Expected to be redirected to "%s" but found "%s" instead', $expected, $actual));
        }
    }

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
}
