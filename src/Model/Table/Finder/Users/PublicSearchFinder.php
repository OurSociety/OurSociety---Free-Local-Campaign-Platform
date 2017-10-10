<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class PublicSearchFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $communityContributors = $query->find('isCommunityContributor');
        $politicians = $query->find('isPolitician');

        return $communityContributors->union($politicians);
    }
}
