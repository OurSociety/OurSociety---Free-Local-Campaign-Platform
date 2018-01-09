<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Articles;

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
                $this->aliasField($query, 'approved'),
                $this->aliasField($query, 'published'),
            ])
            ->contain([
                'ElectoralDistricts' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
                'ArticleTypes' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'id'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
            ]);
    }
}
