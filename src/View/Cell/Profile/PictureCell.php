<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Profile;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\View\Cell;
use OurSociety\Model\Entity\User;
use OurSociety\View\AppView;

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
        $this->setUrl();
    }

    /**
     * Edit method.
     *
     * @return void
     */
    public function edit(): void
    {
        $this->setUrl();
    }

    /**
     * Set URL.
     *
     * @return void Sets the URL to the view.
     */
    private function setUrl(): void
    {
        $this->set(['url' => $this->user->picture]);
    }
}
