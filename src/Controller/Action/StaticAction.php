<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Action;

use Crud\Action\BaseAction;

class StaticAction extends BaseAction
{
    public function _get(): void
    {
        $subject = $this->_subject([
            'success' => true,
        ]);

        $this->_trigger('beforeRender', $subject);
    }
}
