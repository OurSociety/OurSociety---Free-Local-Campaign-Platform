<?php
declare(strict_types=1);

namespace OurSociety\Controller\Component;

use Crud\Controller\Component as Crud;
use Psr\Http\Message\ResponseInterface as Response;

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

    /**
     * {@inheritdoc}.
     *
     * - This method was only overridden to fix case-sensitivity when removing listeners by class name.
     *   ie. removeListener(ViewListener::class) will correctly remove the 'ourSociety\listener\viewListener' key.
     *
     * @see \Crud\Controller\Component\CrudComponent::removeListener
     */
    public function removeListener($name): ?bool
    {
        foreach (array_keys($this->getConfig('listeners')) as $key) {
            if (strtolower($key) === strtolower($name)) {
                return parent::removeListener($key);
            }
        }

        return parent::removeListener($name);
    }

    public function setScaffoldFields(array $config): void
    {
        $this->action()->setConfig('scaffold.fields', $config);
    }
}
