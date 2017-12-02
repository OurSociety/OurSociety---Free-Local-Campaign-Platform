<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\ElectoralDistricts;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForViewActionFinder extends Finder
{
    private const LIMIT_ARTICLES = 4;

    private const LIMIT_EVENTS = 10;

    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->find(IsMunicipalityFinder::class)
            ->contain([
                'Articles' => function (Query $query): Query {
                    return $query
                        ->contain([
                            'ElectoralDistricts' => function (Query $query): Query {
                                return $query->select([
                                    $this->aliasField($query, 'id'),
                                    $this->aliasField($query, 'slug'),
                                ]);
                            },
                        ])
                        ->orderDesc($this->aliasField($query, 'published'))
                        ->limit(self::LIMIT_ARTICLES);
                },
                'Events' => function (Query $query): Query {
                    return $query
                        ->select([
                            $this->aliasField($query, 'id'),
                            $this->aliasField($query, 'name'),
                            $this->aliasField($query, 'location'),
                            $this->aliasField($query, 'start'),
                            $this->aliasField($query, 'electoral_district_id'),
                        ])
                        ->orderDesc($this->aliasField($query, 'start'))
                        ->limit(self::LIMIT_EVENTS);
                },
            ]);
    }
}
