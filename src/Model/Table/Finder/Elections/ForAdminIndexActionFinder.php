<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Elections;

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
                $this->aliasField($query, 'date'),
                $this->aliasField($query, 'state_id'),
                $this->aliasField($query, 'is_state_wide'),
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
