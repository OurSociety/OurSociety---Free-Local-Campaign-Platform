<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Profile;

use Cake\Datasource\ResultSetInterface as ResultSet;
use Cake\View\Cell;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;

/**
 * Picture cell
 */
class ValueMatchCell extends Cell
{
    private const LIMIT = 4;

    /**
     * Default display method.
     *
     * @param User $politician
     * @param User $citizen
     * @param int|null $limit
     * @return void
     */
    public function display(User $politician, User $citizen, ?int $limit = self::LIMIT): void
    {
        /** @var UsersTable $users */
        $users = $this->loadModel('Users');

        $this->set([
            'match' => $users->getMatchPercentage($citizen, $politician),
            'similarities' => $users->Categories->getMatchPercentages($citizen, $politician, false, $limit),
            'differences' => $users->Categories->getMatchPercentages($citizen, $politician, true, $limit),
            'politician' => $politician,
            'limit' => $limit,
        ]);
    }

    public function topics(string $name, ResultSet $topics): void
    {
        $this->set([
            'name' => $name,
            'topics' => $topics,
        ]);
    }
}
