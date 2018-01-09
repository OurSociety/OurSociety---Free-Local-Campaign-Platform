<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Elections;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminViewActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                $this->aliasField($query, 'name'),
                $this->aliasField($query, 'date'),
                $this->aliasField($query, 'election_type'),
                $this->aliasField($query, 'is_state_wide'),
                $this->aliasField($query, 'registration_info'),
                $this->aliasField($query, 'absentee_ballot_info'),
                $this->aliasField($query, 'results_uri'),
                $this->aliasField($query, 'has_election_day_registration'),
                $this->aliasField($query, 'registration_deadline'),
                $this->aliasField($query, 'absentee_request_deadline'),
            ])
            ->contain([
                'States' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
            ]);
    }
}
