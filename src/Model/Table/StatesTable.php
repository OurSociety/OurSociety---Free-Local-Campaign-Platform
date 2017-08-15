<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

class StatesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Elections');
    }
}
