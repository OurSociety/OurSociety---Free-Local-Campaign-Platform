<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Crud\Action as CrudAction;
use Crud\Controller as Crud;
use Crud\Listener as CrudListener;
use OurSociety\Controller\Component as App;
use OurSociety\View\Listener as AppListener;

/**
 * CRUD controller.
 *
 * Controllers that extend this class will have the Crud/CrudUsers/CrudView plugins enabled.
 *
 * @property App\CrudComponent $Crud
 */
abstract class CrudController extends AppController
{
    use Crud\ControllerTrait;

    /**
     * {@inheritdoc}
     *
     * - Configure Crud plugin
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'index' => CrudAction\IndexAction::class,
                'add' => CrudAction\AddAction::class,
                'edit' => CrudAction\EditAction::class,
                'view' => CrudAction\ViewAction::class,
                'delete' => CrudAction\DeleteAction::class,
            ],
            'listeners' => [
                AppListener\ViewListener::class, // @see for CrudView configuration.
                CrudListener\RedirectListener::class,
                CrudListener\RelatedModelsListener::class,
            ],
        ]);
    }
}
