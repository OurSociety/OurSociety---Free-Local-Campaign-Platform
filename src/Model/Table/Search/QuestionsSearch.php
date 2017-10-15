<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Search;

use Search\Manager;

class QuestionsSearch implements Search
{
    public function __invoke(Manager $manager): Manager
    {
        $manager->add('question', 'Search.Like', [
            'before' => true, 'after' => true,
            'fieldMode' => 'OR', 'comparison' => 'LIKE',
            'wildcardAny' => '*', 'wildcardOne' => '?',
            'field' => ['question'],
        ]);

        return $manager;
    }
}
