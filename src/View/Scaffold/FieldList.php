<?php
declare(strict_types=1);

namespace OurSociety\View\Scaffold;

use Cake\Utility\Hash;
use IteratorAggregate;
use OurSociety\Model\Table\AppTable;

final class FieldList implements IteratorAggregate
{
    /**
     * @var Field[]
     */
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public static function fromArray(AppTable $table, array $fields): self
    {
        $map = function ($options, $name) use ($table) {
            return new Field($table, $name, $options);
        };

        return new self(collection(Hash::normalize($fields))->map($map)->toArray());
    }

    public function getIterator()
    {
        return collection($this->fields);
    }
}
