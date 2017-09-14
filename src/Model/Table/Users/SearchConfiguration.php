<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Users;

use Search\Manager as Search;

trait SearchConfiguration
{
    public function searchManager(): Search
    {
        return $this->behaviors()->Search->searchManager()
            ->add('name', 'Search.Like', [
                'before' => true, 'after' => true,
                'fieldMode' => 'OR', 'comparison' => 'LIKE',
                'wildcardAny' => '*', 'wildcardOne' => '?',
                'field' => ['name', 'email']
            ])
            ->value('role');
            //->value('author_id')
            // Here we will alias the 'q' query param to search the `Articles.title`
            // field and the `Articles.content` field, using a LIKE match, with `%`
            // both before and after.
            //->add('q', 'Search.Like', [
            //    'before' => true, 'after' => true,
            //    'fieldMode' => 'OR', 'comparison' => 'LIKE',
            //    'wildcardAny' => '*', 'wildcardOne' => '?',
            //    'field' => ['title', 'content']
            //])
            //->add('foo', 'Search.Callback', [
            //    'callback' => function ($query, $args, $filter) {
            //        // Modify $query as required
            //    }
            //]);
    }
}
