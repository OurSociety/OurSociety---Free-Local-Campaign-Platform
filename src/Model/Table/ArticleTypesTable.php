<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\HasMany;

/**
 * ArticleTypesTable.
 *
 * @property HasMany|PoliticianArticlesTable $Articles
 */
class ArticleTypesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Articles', ['className' => PoliticianArticlesTable::class]);
    }
}
