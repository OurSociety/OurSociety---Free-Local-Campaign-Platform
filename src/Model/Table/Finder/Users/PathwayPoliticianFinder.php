<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;
use OurSociety\Model\Table;

class PathwayPoliticianFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $this->table->hasMany('Articles', [
            'className' => Table\ArticlesTable::class,
            'foreignKey' => 'politician_id',
            'finder' => isset($options['role']) && $options['role'] === User::ROLE_CITIZEN ? 'forCitizen' : 'all',
        ]);

        return $query->find('isPathwayPolitician')->contain(['Articles']);
    }
}
