<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Contests;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminIndexActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                $this->aliasField($query, 'slug'),
                $this->aliasField($query, 'name'),
            ])
            ->contain([
                'ElectoralDistricts' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
                'Elections' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
                'Offices' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'id'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
            ]);
    }
}
