<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\I18n\FrozenDate;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use OurSociety\View\AppView;

abstract class AppEntity extends Entity implements RecordInterface
{
    use Traits\ViewComponentAware;

    public function __construct(array $properties = [], array $options = [])
    {
        $this->setAccess('*', true);
        $this->setAccess('id', false);

        parent::__construct($properties, $options);
    }

    public static function examples(int $count, array $data = null, ?callable $sort = null): array
    {
        $examples = [];
        for ($i = 0; $i < $count; $i++) {
            $examples[] = static::example($data);
        }

        if ($sort !== null) {
            uasort($examples, $sort);
        }

        return $examples;
    }

    public function renderCardElement(AppView $view, array $viewVariables = null): string
    {
        return $this->renderElement($view, 'card', $viewVariables ?? []);
    }

    public function renderSummaryElement(AppView $view, array $viewVariables = null): string
    {
        return $this->renderElement($view, 'summary', $viewVariables ?? []);
    }

    protected function renderElement(AppView $view, string $type, array $viewVariables = null): string
    {
        $className = preg_replace('/.*\\\\(.*)/', '$1', static::class);
        $elementName = sprintf('%s/%s', Inflector::camelize($type), Inflector::underscore($className));
        $viewVariableName = Inflector::variable($className);

        return $view->element($elementName, ($viewVariables ?? []) + [$viewVariableName => $this]);
    }

    protected function _getIdentifier(): ?string
    {
        return $this->_properties['slug'] ?? $this->_properties['id'] ?? null;
    }

    protected function setYearMonth($value)
    {
        if (is_string($value)) {
            [$year, $month] = explode('-', $value);
            $value = FrozenDate::create($year, $month, 1);
        }

        return $value;
    }
}
