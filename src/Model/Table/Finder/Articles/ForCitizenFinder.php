<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $options += ['role' => User::ROLE_CITIZEN];

        if ($options['role'] === User::ROLE_CITIZEN) {
            $query->find('approved')->find('published');
        }

        return $query->find('latest');
    }
}
