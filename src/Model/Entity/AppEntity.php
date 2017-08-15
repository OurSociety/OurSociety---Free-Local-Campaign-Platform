<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use OurSociety\View\AppView;

abstract class AppEntity extends Entity
{
    public function __construct(array $properties = [], array $options = [])
    {
        $this->setAccess('*', true);
        $this->setAccess('id', false);

        parent::__construct($properties, $options);
    }

    public function renderCardElement(AppView $view, array $viewVariables = []): string
    {
        return $this->renderElement($view, 'card', $viewVariables);
    }

    public function renderSummaryElement(AppView $view, array $viewVariables = []): string
    {
        return $this->renderElement($view, 'summary', $viewVariables);
    }

    private function renderElement(AppView $view, string $type, array $viewVariables = []): string
    {
        $className = preg_replace('/.*\\\\(.*)/', '$1', static::class);
        $elementName = sprintf('%s/%s', Inflector::camelize($type), Inflector::underscore($className));
        $viewVariableName = Inflector::variable($className);

        return $view->element($elementName, $viewVariables + [$viewVariableName => $this]);
    }
}
