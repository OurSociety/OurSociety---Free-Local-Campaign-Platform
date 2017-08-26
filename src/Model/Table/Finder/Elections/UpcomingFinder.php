<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Elections;

use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class UpcomingFinder extends Finder
{
    /**
     * {@inheritdoc}. Custom finder to grab the upcoming election.
     */
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->where([
            $this->aliasField($query, 'date', '>=') => FrozenDate::now(),
        ])->orderAsc('date');
    }
}
