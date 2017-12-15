<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Positions;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForPoliticianProfileDeleteActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $identity = $this->getIdentity($options);

        return $query->select([
            $this->aliasField($query, 'id'),
        ])->matching('Politicians', function (Query $query) use ($identity): Query {
            return $query->where([
                $this->aliasField($query, 'id') => $identity->id,
            ]);
        });
    }
}
