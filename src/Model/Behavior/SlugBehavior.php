<?php
declare(strict_types=1);

namespace OurSociety\Model\Behavior;

use Muffin\Slug\Model\Behavior as Slug;
use OurSociety\Model\Table\AppTable;

class SlugBehavior extends Slug\SlugBehavior
{
    /**
     * {@inheritdoc}
     */
    public function __construct(AppTable $table, array $config = [])
    {
        $field = $config['field'] ?? $this->_defaultConfig['field'];
        if (!$table->getSchema()->hasColumn($field)) {
            throw new DisableBehaviorException(sprintf("Slug behavior disabled on tables with no '%s' field.", $field));
        }

        parent::__construct($table, $config);
    }
}
