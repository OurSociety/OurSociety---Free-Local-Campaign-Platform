<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

trait SecurityTrait
{
    /**
     * Enable the following components for recommended CakePHP security settings.
     *
     * @link http://book.cakephp.org/3.0/en/controllers/components/security.html
     */
    protected function enableSecurity(): void
    {
        $this->loadComponent('Csrf');
        $this->loadComponent('Security');
    }
}
