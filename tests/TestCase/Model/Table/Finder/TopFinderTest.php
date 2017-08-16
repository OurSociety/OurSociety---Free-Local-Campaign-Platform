<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table\Finder;

use Cake\ORM\Query;
use Cake\ORM\Table;
use OurSociety\Model\Table\Finder\TopFinder;
use OurSociety\TestSuite\TestCase;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class TopFinderTest extends TestCase
{
    public function testInvoke(): void
    {
        /** @var Table|Mock $table */
        $table = $this->createMock(Table::class);
        /** @var Query|Mock $query */
        $query = $this->createMock(Query::class);

        $query->expects(self::atLeastOnce())->
        $options = [];

        $finder = new TopFinder($table);
        $actual = $finder($query, $options);

        dd($actual->sql());
    }
}
