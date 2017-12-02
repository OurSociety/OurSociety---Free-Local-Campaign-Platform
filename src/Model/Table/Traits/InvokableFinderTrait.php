<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Traits;

use BadMethodCallException;
use Cake\Core\Configure;
use Cake\ORM\BehaviorRegistry;
use Cake\ORM\Query;

/**
 * Invokable trait finder.
 *
 * Adds support for custom finders that are invokable classes.
 *
 * @see \OurSociety\Model\Table\Finder\Finder
 */
trait InvokableFinderTrait
{
    /**
     * {@inheritdoc}. Overrides core `Table::callFinder()` method to support custom finders that are invokable classes.
     */
    public function callFinder($type, Query $query, array $options = null)
    {
        $query->applyOptions($options);
        $options = $query->getOptions();

        if (class_exists($type)) {
            return (new $type($this))($query, $options);
        }

        $namespace = Configure::read('App.namespace');
        $tableName = preg_replace('#^.*\\\\(.*)Table#', '$1', static::class);
        $finderName = ucfirst($type);

        $finderClassNames = [
            sprintf('%s\\Model\\Table\\Finder\\%s\\%sFinder', $namespace, $tableName, $finderName),
            sprintf('%s\\Model\\Table\\Finder\\%sFinder', $namespace, $finderName),
        ];

        foreach ($finderClassNames as $finderClassName) {
            if (class_exists($finderClassName)) {
                $finder = new $finderClassName($this);

                return $finder($query, $options);
            }
        }

        $finder = 'find' . $type;
        if (method_exists($this, $finder)) {
            return $this->{$finder}($query, $options);
        }

        /** @var BehaviorRegistry $behaviors */
        $behaviors = $this->_behaviors;
        if ($behaviors && $behaviors->hasFinder($type)) {
            return $behaviors->callFinder($type, [$query, $options]);
        }

        throw new BadMethodCallException(sprintf('Unknown finder method "%s"', $type));
    }
}
