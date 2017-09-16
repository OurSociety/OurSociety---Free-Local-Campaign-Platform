<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Crud;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use Ingenerator\BehatTableAssert\AssertTable;
use Ingenerator\BehatTableAssert\TableParser\HTMLTable;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Index page.
 */
class IndexPage extends Page
{
    /**
     * Determine if a table has all items.
     *
     * @param TableNode $expected The table node.
     * @return bool True if all table items exist.
     * @throws ElementNotFoundException
     */
    public function assertRecords(TableNode $expected): void
    {
        $indexTable = $this->find('css', '.scaffold-action-index table');

        if (!$indexTable) {
            throw new ElementNotFoundException($this->getDriver(), 'form', 'css', 'form#search');
        }

        (new AssertTable)->isComparable($expected, HTMLTable::fromMinkTable($indexTable), ['ignoreExtraColumns' => true]);
    }
}
