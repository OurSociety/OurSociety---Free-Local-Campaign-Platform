<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class AuthFinder extends Finder
{
    /**
     * {@inheritdoc}. Custom finder for AuthComponent.
     *
     * Used by the AuthComponent to get all the authenticated user's data.
     *
     * TODO: Return associated information as it becomes known, or remove method if never used.
     */
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->contain(['ElectoralDistricts']);
    }
}
