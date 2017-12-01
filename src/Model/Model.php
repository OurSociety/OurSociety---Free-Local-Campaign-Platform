<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\Datasource\RepositoryInterface;
use Cake\ORM\Query;
use Cake\Utility\Inflector;
use OurSociety\Action\Action;
use OurSociety\Model\Table\AppTable;
use ReflectionClass;

abstract class Model
{
    use ModelAwareTrait;

    /**
     * @var RepositoryInterface|AppTable
     */
    protected $repository;

    public function __construct(string $repositoryName = null)
    {
        $repositoryName = $repositoryName ?? (new ReflectionClass($this))->getShortName();
        $this->_setModelClass($repositoryName);
        $this->repository = $this->loadModel();
    }

    public function getByUniqueIdentifier(string $identifier, array $fields = null): EntityInterface
    {
        $query = $this->repository
            ->find('byIdentifier', ['identifier' => $identifier])
            ->select($this->repository->getPrimaryKey());

        if ($fields !== null) {
            $query->select($fields);
        }

        return $query->firstOrFail();
    }

    public function getEntityName(): string
    {
        $entityClass = preg_replace('/.*\\\\([^\\\\]+)$/', '$1', $this->repository->getEntityClass());

        return Inflector::humanize($entityClass);
    }

    public function getQueryForAction(Action $action, array $options = null): Query
    {
        $actionClassName = get_class($action);
        $pattern = sprintf('#^%s\\\\Action\\\\(.+)\\\\[^\\\\]+?\\\\([^\\\\]+)$#', Configure::read('App.namespace'));
        $count = preg_match($pattern, $actionClassName, $matches);
        if ($count !== 1) {
            throw new \RuntimeException(sprintf('Regular expression error when parsing class name "%s"', $actionClassName));
        }
        $finderName = sprintf('for%s%s', $matches[1], $matches[2]);

        $query = $this->repository->find($finderName, $options ?? []);

        if (isset($options['identifier'])) {
            $query->find('byIdentifier');
        }

        return $query;
    }

    public function update(EntityInterface $entity, array $data): EntityInterface
    {
        $entity = $this->repository->patchEntity($entity, $data);

        return $this->repository->saveOrFail($entity);
    }

    public function toggleField(EntityInterface $entity, string $field): EntityInterface
    {
        $value = !(bool)$entity->get($field);

        return $this->saveField($entity, $field, $value);
    }

    public function getContext(): EntityInterface
    {
        return $this->repository->newEntity();
    }

    public function getSlugFromId(string $id): string
    {
        return $this->repository->find()
            ->select(['slug'])
            ->where([$this->repository->aliasField('id') => $id])
            ->firstOrFail()
            ->slug;
    }

    protected function saveField(EntityInterface $entity, string $field, $value): EntityInterface
    {
        $data = [$field => $value];
        $options = ['fieldList' => [$field]];
        $entity = $this->repository->patchEntity($entity, $data, $options);

        return $this->repository->saveOrFail($entity);
    }
}
