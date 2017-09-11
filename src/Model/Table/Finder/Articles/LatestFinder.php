<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class LatestFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->innerJoin(
            [
                'LatestArticles' => $this->table->find()->select([
                    'LatestArticles__slug' => 'slug',
                    'LatestArticles__version' => $query->func()->max('version')
                ])->group('slug')
            ],
            [
                $this->aliasField($query, 'slug', '= LatestArticles__slug'),
                $this->aliasField($query, 'version', '= LatestArticles__version'),
            ]
        );
    }
}
