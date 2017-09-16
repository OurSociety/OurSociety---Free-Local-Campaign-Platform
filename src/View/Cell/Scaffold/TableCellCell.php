<?php
declare(strict_types = 1);

namespace OurSociety\View\Cell\Scaffold;

use Cake\View\Cell;
use OurSociety\Model\Entity\AppEntity;
use OurSociety\Model\Table\UsersTable;
use OurSociety\View\AppView;
use OurSociety\View\Scaffold\Field;

/**
 * TableCell cell.
 */
class TableCellCell extends Cell
{
    /**
     * Display a single question.
     *
     * @param AppEntity $entity
     * @param int $number
     * @return void
     */
    public function display(Field $field, AppEntity $entity): void
    {
        /** @var AppView $view */
        $view = $this->createView();
        $view->set([
            'displayField' => $entity->getScaffoldDisplayField(),
            'modelSchema' => $field->getModelSchema(),
            'primaryKey' => $field->getPrimaryKey($entity),
        ]);

        $this->set([
            'name' => $field->getCellTag($entity),
            'text' => $view->CrudView->process($field->getName(), $entity, $field->getOptions()),
            'options' => $field->getCellOptions($entity),
        ]);
    }
}
