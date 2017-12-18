<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Contests;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminViewActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                $this->aliasField($query, 'id'),
                $this->aliasField($query, 'slug'),
                $this->aliasField($query, 'name'),
                $this->aliasField($query, 'abbreviation'),
                $this->aliasField($query, 'number_elected'),
                $this->aliasField($query, 'votes_allowed'),
                $this->aliasField($query, 'ballot_sub_title'),
                $this->aliasField($query, 'ballot_title'),
                $this->aliasField($query, 'election_id'),
                $this->aliasField($query, 'electorate_specification'),
                $this->aliasField($query, 'has_rotation'),
                $this->aliasField($query, 'sequence_order'),
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
