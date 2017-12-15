<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Qualifications;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForPoliticianProfileEditActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $identity = $this->getIdentity($options);

        return $query->select([
            $this->aliasField($query, 'id'),
            $this->aliasField($query, 'name'),
            $this->aliasField($query, 'institution'),
            $this->aliasField($query, 'started'),
            $this->aliasField($query, 'ended'),
        ])->matching('Politicians', function (Query $query) use ($identity): Query {
            return $query->where([
                $this->aliasField($query, 'id') => $identity->id,
            ]);
        });
    }
}
