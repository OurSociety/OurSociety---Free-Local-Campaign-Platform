<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->find(LatestFinder::class)
            ->find(ApprovedFinder::class)
            ->find(PublishedFinder::class)
            ->contain([
                'ElectoralDistricts' => function (Query $query): Query {
                    return $query->select([
                        $this->aliasField($query, 'id'),
                        $this->aliasField($query, 'slug'),
                    ]);
                },
            ])
            ->orderDesc($this->aliasField($query, 'published'));
    }
}
