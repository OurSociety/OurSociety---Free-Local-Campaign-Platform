<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Component;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Ingenerator\BehatTableAssert\AssertTable;
use Ingenerator\BehatTableAssert\TableParser\HTMLTable;
use WebDriver\Exception\NoSuchElement;

abstract class Listing extends Component
{
    public function containsRecords(TableNode $expected): void
    {
        (new AssertTable)->containsColumns(
            $expected,
            HTMLTable::fromMinkTable($this->findByCss('.listing .listing-table'))
        );
    }

    public function edit($record): void
    {
        $this->findRecordButton($record, 'Edit')->click();
    }

    private function findRecordButton($record, $button): NodeElement
    {
        $link = $this->findRowByText($record)->findLink($button);

        if ($link === null) {
            throw new NoSuchElement(sprintf('Could not find record button matching "%s"', $button));
        }

        return $link;
    }

    private function findRowByText($rowText): NodeElement
    {
        return $this->findByCss(sprintf('table tr:contains("%s")', $rowText));
    }
}
