<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\ElectoralDistricts;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForEditActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->find(IsMunicipalityFinder::class)
            ->select([
                $this->aliasField($query, 'id'),
                $this->aliasField($query, 'name'),
                $this->aliasField($query, 'description'),
            ])
            ->contain([
                'DistrictTypes' => function (Query $query): Query {
                    return $query->select([
                        $this->aliasField($query, 'id_vip'),
                    ]);
                },
            ]);
    }
}
