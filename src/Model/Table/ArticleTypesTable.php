<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\HasMany;

/**
 * ArticleTypesTable.
 *
 * @property HasMany|ArticlesTable $Articles
 */
class ArticleTypesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Articles', ['className' => ArticlesTable::class]);
    }
}
