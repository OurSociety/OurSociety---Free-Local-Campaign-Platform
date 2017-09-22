<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder;

use Cake\ORM\Query;

class SlugFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        dd($query);
        dd($options);
        return $query;
    }
}
