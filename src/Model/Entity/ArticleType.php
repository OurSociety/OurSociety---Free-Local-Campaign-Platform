<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\Utility\Text;

/**
 * ArticleType Entity
 *
 * @property string $id
 * @property string $name
 */
class ArticleType extends AppEntity
{
    public static function example(array $data = null): self
    {
        $names = ['Policy', 'Plan', 'Vision'];
        $name = $names[random_int(0, 2)];
        $id = Text::uuid();
        $data = ($data ?? []) + ['id' => $id, 'name' => $name];

        return new self($data);
    }

    public function printName(): string
    {
        return $this->_properties['name'] ?? __('Miscellaneous');
    }

    public function getIcon(): string
    {
        return 'folder-o';
    }
}
