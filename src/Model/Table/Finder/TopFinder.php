<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder;

use Cake\ORM\Query;

class TopFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query;
    }
}
