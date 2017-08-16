<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;

class PoliticianForCitizenFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $options += ['role' => User::ROLE_CITIZEN];

        // TODO: For now we will allow users to see non-verified politicians
        //if ($options['role'] === User::ROLE_CITIZEN) {
        //    $query->find('isVerified')->find('hasAnsweredQuestions');
        //}

        return $query->find('politician', ['role' => 'citizen']);
    }
}
