<?php
declare(strict_types = 1);

namespace OurSociety\View;

/**
 * A view class that is used for AJAX responses.
 * Currently only switches the default layout and sets the response type -
 * which just maps to text/html by default.
 */
class AjaxView extends AppView
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->layout('ajax');
        $this->response->type('ajax');
    }
}
