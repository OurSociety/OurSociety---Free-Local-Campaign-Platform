<?php
declare(strict_types = 1);

namespace OurSociety\View\Scaffold;

use Cake\Core\InstanceConfigTrait;
use Cake\Database\Schema\TableSchema;
use Cake\View\CellTrait;
use OurSociety\Model\Entity\AppEntity;
use OurSociety\Model\Table\AppTable;
use OurSociety\View\AppView;

class Field
{
    use InstanceConfigTrait;
    use CellTrait;

    /**
     * @var AppTable
     */
    protected $_model;

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var array
     */
    protected $_defaultConfig = ['formatter' => null, 'empty' => true];

    public function __construct(AppTable $model, string $name, ?array $config = null)
    {
        $this->_model = $model;
        $this->_name = $name;

        $this->setConfig($config);
    }

    public function getCellOptions(AppEntity $entity): array
    {
        $options = $this->getConfig('td', []);

        if ($this->isDisplayField($entity)) {
            $options += ['scope' => 'row'];
        }

        return $options;
    }

    public function getCellTag(AppEntity $entity): string
    {
        return $this->isDisplayField($entity) ? 'th' : 'td';
    }

    public function getName(): string
    {
        return $this->_name;
    }

    public function getEmpty()
    {
        return $this->getConfig('empty', true);
    }

    public function getFormatter()
    {
        return $this->getConfig('formatter');
    }

    public function getOptions(): array
    {
        $options = $this->getConfig();
        unset($options['td']);

        return $options;
    }

    protected function isDisplayField(AppEntity $entity): bool
    {
        return $entity->getScaffoldDisplayField() === $this->_name;
    }

    public function renderTableCell(AppEntity $entity, AppView $view): string
    {
        return (string)$view->cell('Scaffold/TableCell', [$this, $entity]);
    }

    public function getModelSchema(): TableSchema
    {
        return $this->_model->getSchema();
    }

    public function getPrimaryKey(AppEntity $entity): string
    {
        return $this->_model->hasSlugField() ? $this->_model->getSlugFieldName() : $this->_model->getPrimaryKey();
    }
}
