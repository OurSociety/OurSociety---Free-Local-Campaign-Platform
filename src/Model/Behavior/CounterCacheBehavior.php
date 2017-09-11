<?php
declare(strict_types=1);

namespace OurSociety\Model\Behavior;

use Cake\ORM\Behavior as Cake;
use Cake\ORM\Table;

class CounterCacheBehavior extends Cake\CounterCacheBehavior
{
    /**
     * {@inheritdoc}. Unset className so it doesn't get mistaken as a field name.
     */
    public function __construct(Table $table, array $config = [])
    {
        unset($config['className']);

        parent::__construct($table, $config);
    }
}
