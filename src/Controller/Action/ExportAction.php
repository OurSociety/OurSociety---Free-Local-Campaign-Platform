<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Cake\ORM\ResultSet;
use Crud\Action as Crud;

class ExportAction extends Crud\IndexAction
{
    public function _handle(): void
    {
        parent::_handle();

        $controller = $this->_controller();
        $controller->viewBuilder()->setClassName('CsvView.Csv');

        /** @var ResultSet $items */
        $items = $controller->viewVars[$this->viewVar()];

        $controller->set([
            '_header' => $items->first()->visibleProperties(),
            '_serialize' => $this->viewVar(),
        ]);
    }
}
