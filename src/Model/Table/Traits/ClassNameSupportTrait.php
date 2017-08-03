<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Traits;

use OurSociety\Model\Behavior\DisableBehaviorException;

trait ClassNameSupportTrait
{
    /**
     * {@inheritdoc}
     */
    public function addBehavior($name, array $options = []): void
    {
        if (class_exists($name)) {
            $options += ['className' => $name];
            $name = $options['name'] ?? $this->getBehaviorName($name);
        }

        try {
            parent::addBehavior($name, $options);
        } catch (DisableBehaviorException $exception) {
            // no-op: The behavior disabled itself on purpose.
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeBehavior($name): void
    {
        parent::removeBehavior($this->getBehaviorName($name));
    }

    /**
     * Get behavior name.
     *
     * @param string $name The name or class name.
     * @return string The name.
     */
    private function getBehaviorName(string $name): string
    {
        return preg_replace('#^.*\\\\(.*)Behavior#', '$1', $name);
    }
}
