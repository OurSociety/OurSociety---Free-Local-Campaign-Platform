<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Traits;

use BadMethodCallException;
use Cake\Core\Configure;
use Cake\ORM\Query;

trait InvokableFinderTrait
{
    /**
     * {@inheritdoc}
     */
    public function callFinder($type, Query $query, array $options = [])
    {
        $query->applyOptions($options);
        $options = $query->getOptions();

        $finderClassName = sprintf(
            '%s\\Model\\Table\\Finder\\%s\\%sFinder',
            Configure::read('App.namespace'),
            $this->getAlias(),
            ucfirst($type)
        );

        if (class_exists($finderClassName)) {
            $finder = new $finderClassName($this);
            return $finder($query, $options);
        }

        $finder = 'find' . $type;
        if (method_exists($this, $finder)) {
            return $this->{$finder}($query, $options);
        }

        if ($this->_behaviors && $this->_behaviors->hasFinder($type)) {
            return $this->_behaviors->callFinder($type, [$query, $options]);
        }

        throw new BadMethodCallException(
            sprintf('Unknown finder method "%s"', $type)
        );
    }
}
