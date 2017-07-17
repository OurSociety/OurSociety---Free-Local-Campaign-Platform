<?php
declare(strict_types = 1);

namespace OurSociety\View;

use BootstrapUI\View\Helper as BootstrapUI;
use CrudView\View\CrudView;

/**
 * Application View
 *
 * Your application’s default view class, based on CrudView.
 *
 * @property BootstrapUI\FormHelper $Form
 * @property Helper\HtmlHelper $Html
 */
class AppView extends CrudView
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->layout('site');
    }
}
