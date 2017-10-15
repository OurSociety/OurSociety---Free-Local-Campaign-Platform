<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use IteratorAggregate;
use OurSociety\Model\Entity\AppEntity;
use OurSociety\Model\Table\AppTable;

final class FieldList implements IteratorAggregate
{
    /**
     * @var Field[]
     */
    private $fields;

    public function __construct(array $fields)
    {
        //dd($fields);
        $this->fields = $fields;
    }

    public static function fromArray(AppTable $table, array $fields): self
    {
        $map = function ($options, $name) use ($table) {
            $fieldClass = sprintf('%sField', $options['type'] ?? 'Text');
            $fieldClass = str_replace('FieldList', $fieldClass, self::class);

            $entityClass = Inflector::singularize($table->getRegistryAlias());
            $entityClass = str_replace('AppEntity', $entityClass, AppEntity::class);

            return new $fieldClass($name, $options, new $entityClass);
        };

        return new self(collection(Hash::normalize($fields))->map($map)->toArray());
    }

    public function getIterator()
    {
        return collection($this->fields);
    }
}
