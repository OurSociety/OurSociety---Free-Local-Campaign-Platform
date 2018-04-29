<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Ballot;

use Cake\View\Cell;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;

/**
 * UserPoliticianMatch cell
 *
 * Displaying the match between politician and citizen
 */
class UserPoliticianMatchCell extends Cell
{

    /**
     * Default display method.
     *
     * @param User $politician
     * @param User|null $citizen
     * @return void
     */
    public function display(User $citizen, User $politician): void
    {
        /** @var UsersTable $users */
        $users = $this->loadModel('Users');

        $this->set([
            'match' => $users->getMatchPercentage($citizen, $politician),
        ]);
    }
}
