<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;
use OurSociety\Model\Table;

class PoliticianFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $this->table->hasMany('Articles', [
            'className' => Table\ArticlesTable::class,
            'foreignKey' => 'politician_id',
            'finder' => isset($options['role']) && $options['role'] === User::ROLE_CITIZEN ? 'forCitizen' : 'all',
        ]);
        $this->table->hasMany('Awards', [
            'className' => Table\AwardsTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->table->hasMany('Positions', [
            'className' => Table\PositionsTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->table->hasMany('Qualifications', [
            'className' => Table\QualificationsTable::class,
            'foreignKey' => 'politician_id'
        ]);
        $this->table->hasMany('Videos', [
            'className' => Table\VideosTable::class,
            'foreignKey' => 'politician_id',
            'conditions' => ['featured' => false] // TODO: Move to finder
        ]);
        $this->table->hasOne('FeaturedVideos', [
            'className' => Table\VideosTable::class,
            'foreignKey' => 'politician_id',
            'conditions' => ['featured' => true] // TODO: Move to finder
        ]);

        return $query->find('isPolitician')
            ->contain(['Articles', 'Awards', 'Positions', 'Qualifications', 'Videos', 'FeaturedVideos']);
    }
}
