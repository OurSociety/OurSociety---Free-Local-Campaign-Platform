<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

trait ClassNameSupportTrait
{
    /**
     * {@inheritdoc}. Load components by class name instead of name.
     *
     * @param string $name The full-qualified class name.
     * @param array $config The remaining config, with 'name' key if you want a different name.
     */
    public function loadComponent($name, array $config = []): void
    {
        if (class_exists($name)) {
            $config += ['className' => $name];
            $name = $config['name'] ?? preg_replace('#^.*\\\\(.*)Component#', '$1', $name);
        }

        parent::loadComponent($name, $config);
    }
}
