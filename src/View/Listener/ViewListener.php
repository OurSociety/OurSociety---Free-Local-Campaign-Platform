<?php
declare(strict_types = 1);

namespace OurSociety\View\Listener;

use Cake\Core\Configure;
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
}
