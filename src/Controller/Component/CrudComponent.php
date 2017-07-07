<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Component;

use Cake\Http\Response;
use Crud\Controller\Component as Crud;

/**
 * Crud component
 *
 * Scaffolding on steroids! :)
 */
class CrudComponent extends Crud\CrudComponent
{
    /**
     * {@inheritdoc}.
     *
     * - This method was only overridden to fix the return type hint since `\Cake\Network\Response is now deprecated.
     *
     * @see \Crud\Controller\Component\CrudComponent::execute
     */
    public function execute($controllerAction = null, $args = []): Response
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */

        return parent::execute($controllerAction, $args);
    }
}
