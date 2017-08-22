<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Cake\Controller\Controller;
use Crud\Action as Crud;

class EditAction extends Crud\EditAction
{
    use Traits\FindMethodTrait;

    public function __construct(Controller $Controller, $config = [])
    {
        parent::__construct($Controller, $config);

        $this->setConfig([
            'scaffold' => [
                'actions_blacklist' => [
                    'lookup', // TODO: This was showing up on politician articles.
                    'export', // TODO: This was showing up on politician articles.
                ],
                'fields_blacklist' => ['created', 'modified'],
            ],
        ]);
    }
}
