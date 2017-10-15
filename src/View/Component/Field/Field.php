<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cake\View\CellTrait;
use OurSociety\Model\Entity\RecordInterface;
use OurSociety\View\AppView;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\RecordAwareTrait;

abstract class Field extends Component
{
    use CellTrait;
    use InstanceConfigTrait;
    use RecordAwareTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $_defaultConfig = ['formatter' => null, 'empty' => true];

    public function __construct(string $name, ?array $config = null, RecordInterface $record = null)
    {
        $this->setName($name);
        $this->setConfig($config);
        $this->setRecord($record);
    }

    public function getCellOptions(RecordInterface $record): array
    {
        $options = $this->getConfig('td', []);

        if ($this->isDisplayField($record)) {
            $options += ['scope' => 'row'];
        }

        return $options;
    }

    public function getCellTag(RecordInterface $record): string
    {
        return $this->isDisplayField($record) ? 'th' : 'td';
    }

    public function getName(): string
    {
        return $this->name;
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

    public function hasTitle(): bool
    {
        return ($this->getOptions()['title'] ?? null) !== null;
    }

    public function getTitle(): string
    {
        return $this->getOptions()['title'];
    }

    public function renderTableCell(RecordInterface $record, AppView $view): string
    {
        return (string)$view->cell('Scaffold/TableCell', [$this, $record]);
    }

    /**
     * @param RecordInterface $record
     * @return bool
     */
    public function isDisplayField(RecordInterface $record): bool
    {
        return $record->getDisplayFieldName() === $this->name;
    }

    protected function getValue()
    {
        $getValue = function (EntityInterface $entity, array $path) use (&$getValue) {
            $field = array_shift($path);

            if (count($path) === 0) {
                return $entity->get($field);
            }

            return $getValue($entity->get($field), $path);
        };

        return $getValue($this->record, explode('.', $this->getName()));
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }
}
