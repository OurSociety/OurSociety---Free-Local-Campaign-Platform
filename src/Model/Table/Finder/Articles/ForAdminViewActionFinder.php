<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminViewActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                $this->aliasField($query, 'slug'),
                $this->aliasField($query, 'name'),
                $this->aliasField($query, 'body'),
                $this->aliasField($query, 'approved'),
                $this->aliasField($query, 'published'),
                $this->aliasField($query, 'created'),
                $this->aliasField($query, 'modified'),
                $this->aliasField($query, 'version'),
            ])
            ->contain([
                'ArticleTypes' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'id'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
                'Aspects' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
                'ElectoralDistricts' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
                'Politicians' => function (Query $query) {
                    return $query->select([
                        $this->aliasField($query, 'slug'),
                        $this->aliasField($query, 'name'),
                    ]);
                },
            ]);
    }
}
