<?php
declare(strict_types = 1);

namespace OurSociety\Listener;

use Cake\Core\Configure;
use Cake\Database\Exception as DatabaseException;
use Cake\ORM\Table;
use Crud\Action\BaseAction;
use CrudView\Listener as CrudView;
use CrudView\Menu\MenuItem;
use OurSociety\Controller\CrudController;

class ViewListener extends CrudView\ViewListener
{
    /**
     * {@inheritdoc}
     *
     * - This method was only overridden to fix IDE type hinting of the return type.
     *
     * @param string|null $name The name of the action.
     * @return BaseAction The action.
     */
    protected function _action($name = null): BaseAction
    {
        return parent::_action($name);
    }

    protected function _associations(array $whitelist = [])
    {
        $modifyAssociationsByType = function (array $associations): array {
            $setAssociationPrimaryKeyToSlug = function (array $config): array {
                /** @var Table $table */
                $table = $this->_controller()->loadModel($config['model']);

                if ($table->getSchema()->column('slug') !== null) {
                    $config['primaryKey'] = 'slug';
                }

                return $config;
            };

            $setControllerName = function (array $config): array {
                switch ($config['controller']) {
                    case 'Categories': $config['controller'] = 'Aspects';
                }

                return $config;
            };

            return collection($associations)
                ->map($setAssociationPrimaryKeyToSlug)
                ->map($setControllerName)
                ->toArray();
        };

        return collection(parent::_associations($whitelist))->map($modifyAssociationsByType)->toArray();
    }

    /**
     * {@inheritdoc}
     *
     * - This method was only overridden to fix IDE type hinting of the return type.
     *
     * @param string|null $name The name of the action.
     * @return BaseAction The action.
     */
    protected function _controller(): CrudController
    {
        return parent::_controller();
    }

    /**
     * {@inheritdoc}
     *
     * - Remove lookup action.
     *
     * @return MenuItem[]
     */
    protected function _getAllowedActions(): array
    {
        $allowedActions = parent::_getAllowedActions();
        unset($allowedActions['lookup']);

        return $allowedActions;
    }

    protected function _getControllerActionConfiguration($actionName, $config)
    {
        [$scope, $actionConfig] = parent::_getControllerActionConfiguration($actionName, $config);

        if ($actionConfig['title'] === 'Dashboard') {
            $scope = 'table';
            $actionConfig['title'] = '<i class="fa fa-th-large"></i>' . ' ' . $actionConfig['title'];
            $actionConfig['options'] = ['class' => ['btn', 'btn-info']];
        }

        if ($actionConfig['title'] === 'Export') {
            $scope = 'table';
            $actionConfig['title'] = '<i class="fa fa-download"></i>' . ' ' . $actionConfig['title'];
            $actionConfig['options'] = ['class' => ['btn', 'btn-secondary']];
        }

        return [$scope, $actionConfig];
    }


    /**
     * {@inheritdoc}
     *
     * - Override default utility navigation provided by UtilityNavigationTrait in parent class.
     *
     * @return MenuItem[]
     */
    protected function _getUtilityNavigation(): array
    {
        $currentUser = $this->_controller()->Auth->user();

        if (!$currentUser) {
            return [];
        }

        return [
            new MenuItem('Citizen', ['_name' => 'citizen:dashboard']),
            new MenuItem('Politician', ['_name' => 'politician:dashboard']),
            new MenuItem('Admin', ['_name' => 'admin:dashboard']),
            new MenuItem('Log Out', ['_name' => 'users:logout']),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * - Strips primary key value out of page titles.
     */
    protected function _getPageTitle(): string
    {
        return str_replace(sprintf(' #%s', $this->_primaryKeyValue()), '', parent::_getPageTitle());
    }

    //protected function _getPageVariables(): array
    //{
    //    /** @var Table $table */
    //    $table = $this->_table();
    //
    //    return [
    //        'primaryKey' => $table->getSchema()->column('slug') !== null ? 'slug' : $table->getPrimaryKey(),
    //    ] + parent::_getPageVariables();
    //}

    /**
     * {@inheritdoc}
     */
    protected function _getSiteTitle(): string
    {
        return Configure::read('App.namespace');
    }

    /**
     * {@inheritdoc}
     */
    protected function _getSiteTitleLink(): array
    {
        return ['_name' => 'pages:home'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getSiteTitleImage(): string
    {
        return '../img/banner.png';
    }

    /**
     * {@inheritdoc}
     */
    protected function _getViewBlocks(): array
    {
        return [
            'before_view' => ['Scaffold/before_view' => 'element'],
            'before_index' => ['Scaffold/before_index' => 'element'],
        ];
    }

    /**
     * {@inheritdoc}. Custom logic for determining scaffold fields.
     *
     * @param array $associations
     * @return array
     */
    protected function _scaffoldFields(array $associations = []): array
    {
        /** @var Table $table */
        $table = $this->_table();
        $tableSchema = $table->getSchema();

        $defaultEmpty = function (array $options, string $field) use ($tableSchema) {
            if (isset($options['empty'])) {
                return $options;
            }

            $empty = true;
            if (isset($options['type']) && $options['type'] === 'radio') {
                $empty = 'None';
            }

            return $options + ['empty' => $empty];
        };

        $defaultHelp = function (array $options, string $field) use ($tableSchema){
            $comment = $tableSchema->column($field)['comment'];
            if ($comment !== '' && !isset($options['help'])) {
                $options['help'] = $comment ?? null;
            }

            return $options;
        };

        return collection(parent::_scaffoldFields($associations))
            ->map($defaultEmpty)
            ->map($defaultHelp)
            ->toArray();
    }

    protected function _table(): Table
    {
        /** @var Table $table */
        $table = parent::_table();

        try {
            if ($table->getSchema()->column('slug') !== null) {
                //$table->setPrimaryKey('slug'); // TODO: This breaks relations or CRUD navigation depending on set/unset
            }
        } catch (DatabaseException $exception) {
            // no-op: ignore exceptions for missing tables.
        }

        return $table;
    }
}
