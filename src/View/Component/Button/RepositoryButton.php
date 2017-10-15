<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

use Cake\Datasource\RepositoryInterface;
use OurSociety\ORM\TableRegistry;

/**
 * Repository button.
 *
 * Buttons that act on an entire repository/table - e.g. the create button adds a record to the table.
 */
abstract class RepositoryButton extends Button
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param RepositoryInterface|string|null $repository
     */
    public function __construct($repository = null)
    {
        $this->setRepository($repository);
    }

    final public function getButtonScope(): string
    {
        return self::SCOPE_REPOSITORY;
    }

    public function getButtonUrl(): array
    {
        return [
            'controller' => $this->getControllerName(),
            'action' => $this->getActionName(),
        ];
    }

    /**
     * @param RepositoryInterface|string $repository
     * @return RepositoryButton
     */
    public function withRepository($repository): self
    {
        $button = clone $this;
        $button->setRepository($repository);

        return $button;
    }

    abstract protected function getActionName(): string;

    /**
     * @return RepositoryInterface
     */
    protected function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    protected function getControllerName(): string
    {
        return $this->getRepository()->getAlias();
    }

    /**
     * @param RepositoryInterface|string|null $repository
     * @return void
     */
    private function setRepository($repository = null): void
    {
        if (is_string($repository)) {
            $repository = TableRegistry::get($repository);
        }

        $this->repository = $repository;
    }
}
