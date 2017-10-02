<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Profile;

use Cake\View\Cell;
use OurSociety\Model\Entity\User;

/**
 * Picture cell
 */
/** @noinspection LowerAccessLevelInspection */
class PictureCell extends Cell
{
    /**
     * @var User $user The profile user.
     */
    protected $user;

    protected $_validCellOptions = ['user'];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display(): void
    {
        $this->setUser();
    }

    /**
     * Edit method.
     *
     * @return void
     */
    public function edit(): void
    {
        $this->setUser();
    }

    /**
     * Set common view variables.
     *
     * @return void
     */
    private function setUser(): void
    {
        $this->set(['user' => $this->user]);
    }
}
