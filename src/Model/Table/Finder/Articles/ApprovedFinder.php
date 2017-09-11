<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ApprovedFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->where([
            $this->aliasField($query, 'approved', 'IS NOT') => null,
        ]);
    }
}
