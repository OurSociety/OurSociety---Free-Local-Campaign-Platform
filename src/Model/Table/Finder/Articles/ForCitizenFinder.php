<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Articles;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $options += ['user' => null];

        /** @var User|null $user */
        $user = $options['user'];

        if ($user !== null && $user->isCitizen()) {
            $query
                ->find('approved')
                ->find('published');
        }

        return $query->find('latest')
            ->contain(['ElectoralDistricts'])
            ->orderDesc('published');
    }
}
