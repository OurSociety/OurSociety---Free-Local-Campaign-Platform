<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\ElectoralDistricts;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForMunicipalityProfileFinder extends Finder
{
    private const LIMIT_ARTICLES = 4;

    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->find('isMunicipality')
            ->contain([
                'Articles' => function(Query $query) {
                    return $query
                        ->contain('ElectoralDistricts', function (Query $query) {
                            return $query->select(['id', 'slug']);
                        })
                        ->orderDesc('published')
                        ->limit(self::LIMIT_ARTICLES);
                }
            ]);
    }
}
