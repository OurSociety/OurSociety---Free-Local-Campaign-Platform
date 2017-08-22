<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Crud;

use Behat\Gherkin\Node\TableNode;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Index page.
 */
class IndexPage extends Page
{
    /**
     * Determine if a table has all items.
     *
     * @param TableNode $table The table node.
     * @return bool True if all table items exist.
     */
    public function hasTableItems(TableNode $table): bool
    {
        foreach ($table->getHash() as $row) {
            foreach ($row as $heading => $value) {
                $heading = $this->find('css', sprintf('.scaffold-action-index .table thead tr th:contains("%s")', $heading));
                $cell = $this->find('css', sprintf('.scaffold-action-index .table tbody tr:contains("%s")', $value));

                if (in_array(null, [$heading, $cell])) {
                    return false;
                }
            }
        }

        return true;
    }
}
