<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use OurSociety\TestSuite\Behat\Page\Page;

trait CurrentPageAwareTrait
{
    /**
     * @var Page
     */
    protected $currentPage;

    protected function setCurrentPage(string $page): void
    {
        $this->currentPage = $this->{sprintf('get%sPage', str_replace(' ', '', ucwords($page)))}();
    }

    protected function getCurrentPage(): Page
    {
        return $this->currentPage;
    }
}
