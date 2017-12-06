<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Crud\Action\LookupAction;
use Crud\Controller as Crud;
use Crud\Listener as CrudListener;
use CrudView\Listener as CrudViewListener;
use OurSociety\Controller\Component as App;
use OurSociety\Listener as AppListener;

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

        $this->loadComponent('Crud', [
            'actions' => [
                'index' => Action\IndexAction::class,
                'add' => Action\AddAction::class,
                'edit' => Action\EditAction::class,
                'view' => Action\ViewAction::class,
                'delete' => Action\DeleteAction::class,
                'export' => Action\ExportAction::class,
                'lookup' => LookupAction::class,
            ],
            'listeners' => [
                AppListener\ViewListener::class, // All CrudView configuration inside this class.
                CrudViewListener\ViewSearchListener::class,
                CrudListener\SearchListener::class,
                CrudListener\RedirectListener::class,
                AppListener\RelatedModelsListener::class,
            ],
        ]);
    }

    /**
     * Get field options for year month fields.
     *
     * TODO: Create a custom `YearMonthWidget` and map it in `AppView`.
     *
     * @return array
     */
    protected function getFieldOptionsForYearMonth(): array
    {
        $birthDate = $this->getIdentity()->born;

        return [
            //'maxYear' => date('Y'),
            //'minYear' => $birthDate ? $birthDate->year : 1900,
            //'empty' => ['month' => 'Month', 'year' => 'Year'],
            //'style' => ['year' => 'display: none'],
            'type' => 'month',
            //'day' => false,
        ];
    }
}
