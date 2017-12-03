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
        $class = get_class($action);
        $pattern = sprintf('#^%s\\\\Action\\\\((.+)\\\\)?[^\\\\]+?\\\\([^\\\\]+)$#', Configure::read('App.namespace'));
        $count = preg_match($pattern, $class, $matches);
        if ($count !== 1) {
            throw new \RuntimeException(sprintf('Could not get finder name for class name "%s"', $class));
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$subject, $prefixWithSlash, $prefix, $actionName] = $matches;

        $finderName = sprintf('for%s%s', $prefix, $actionName);

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

    public function getSelectFieldValues(array $fields): array
    {
        $values = [];
        foreach ($fields as $field) {
            $tableName = Inflector::tableize(str_replace('_id', '', $field));
            $modelName = Inflector::classify($tableName);
            $variableName = Inflector::variable($tableName);

            if (isset($model->$modelName)) {
                $values[$variableName] = $this->$modelName->find('list', ['limit' => 200]);
            }
        }

        return $values;
    }

    protected function saveField(EntityInterface $entity, string $field, $value): EntityInterface
    {
        $data = [$field => $value];
        $options = ['fieldList' => [$field]];
        $entity = $this->repository->patchEntity($entity, $data, $options);

        return $this->repository->saveOrFail($entity);
    }
}
