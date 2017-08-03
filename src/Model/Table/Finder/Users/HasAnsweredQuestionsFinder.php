<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class HasAnsweredQuestionsFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->where(['answer_count' > 0]);
    }
}
