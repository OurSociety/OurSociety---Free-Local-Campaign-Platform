<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder;

use Cake\ORM\Query;
use Cake\ORM\Table;

abstract class Finder
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * Constructor.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    abstract public function __invoke(Query $query, array $options = []): Query;
}
