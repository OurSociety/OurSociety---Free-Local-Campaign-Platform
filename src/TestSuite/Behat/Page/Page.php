<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use Behat\Mink\Element\ElementInterface;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page as BasePage;

abstract class Page extends BasePage
{
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
}
