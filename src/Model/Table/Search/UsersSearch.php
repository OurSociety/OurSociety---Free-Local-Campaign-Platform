<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Search;

use Search\Manager;

class UsersSearch implements Search
{
    public function __invoke(Manager $manager): Manager
    {
        $manager->add('name', 'Search.Like', [
            'before' => true, 'after' => true,
            'fieldMode' => 'OR', 'comparison' => 'LIKE',
            'wildcardAny' => '*', 'wildcardOne' => '?',
            'field' => ['name', 'email'],
        ]);

        $manager->value('role');

        return $manager;
    }
}
