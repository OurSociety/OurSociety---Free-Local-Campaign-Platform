<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\I18n\Time;
use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class WasApprovedThisYearFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->find('approved')->where([
            $this->aliasField($query, 'approved', '>') => Time::now()->subYear(),
        ]);
    }
}
