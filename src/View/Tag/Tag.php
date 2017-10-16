<?php
declare(strict_types=1);

namespace OurSociety\View\Tag;

abstract class Tag
{
    public function mergeClasses($options, $classes): array
    {
        /** @noinspection UnnecessaryCastingInspection */
        return ['class' => array_unique(array_merge((array)($options['class'] ?? []), $classes))] + $options;
    }

    public function getElementName(): string
    {
        return str_replace(['\\', 'OurSociety/View/'], ['/', ''], static::class);
    }
}
