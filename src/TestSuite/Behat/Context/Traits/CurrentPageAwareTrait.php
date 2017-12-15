<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use OurSociety\TestSuite\Behat\Page\Page;

trait CurrentPageAwareTrait
{
    use CommonContextAwareTrait;

    /**
     * @var Page
     */
    public $page;

    protected function getPagePropertyName(string $page): string
    {
        return lcfirst(str_replace(' ', '', ucwords($page)));
    }

    protected function setCurrentPage(string $page): Page
    {
        $pageObject = $this->{$this->getPagePropertyName($page)};

        $this->getCommonContext()->page = $pageObject;

        return $pageObject;
    }

    protected function getCurrentPage(): Page
    {
        return $this->getCommonContext()->page;
    }
}
