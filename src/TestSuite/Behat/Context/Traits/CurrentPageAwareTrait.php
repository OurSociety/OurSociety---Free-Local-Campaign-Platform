<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use OurSociety\TestSuite\Behat\Page\Page;

trait CurrentPageAwareTrait
{
    /**
     * @var Page
     */
    protected $page;

    protected function getPagePropertyName(string $page): string
    {
        return lcfirst(str_replace(' ', '', ucwords($page)));
    }

    protected function setCurrentPage(string $page): Page
    {
        $pageObject = $this->{$this->getPagePropertyName($page)};

        if (isset($this->common)) {
            $this->common->page = $pageObject;
        } else {
            $this->page = $pageObject;
        }

        return $pageObject;
    }

    protected function getCurrentPage(): Page
    {
        if (isset($this->common)) {
            return $this->common->page;
        }

        return $this->page;
    }
}
