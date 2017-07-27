<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Profile;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
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

    public function __construct(
        ServerRequest $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $cellOptions = []
    ) {
        $this->_validCellOptions = ['user'];

        parent::__construct($request, $response, $eventManager, $cellOptions);
    }

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
