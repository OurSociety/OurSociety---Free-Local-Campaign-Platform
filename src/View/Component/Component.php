<?php
declare(strict_types=1);

namespace OurSociety\View\Component;

use Cake\Utility\Inflector;
use ReflectionClass;

abstract class Component implements ComponentInterface
{
    public function mergeClasses($options, $classes): array
    {
        /** @noinspection UnnecessaryCastingInspection */
        return ['class' => array_unique(array_merge((array)($options['class'] ?? []), $classes))] + $options;
    }

    public function getElementName(): string
    {
        $path = pathinfo(str_replace(['\\', 'OurSociety/View/'], ['/', ''], static::class));

        return sprintf('%s/%s', $path['dirname'], Inflector::underscore($path['filename']));
    }

    public function getViewVariableName(): string
    {
        $reflectionClass = new ReflectionClass($this);
        $unqualifiedClassName = $reflectionClass->getShortName();

        return lcfirst($unqualifiedClassName);
    }
}
