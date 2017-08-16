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
        if ($table->getSchema()->column('slug') === null) {
            throw new DisableBehaviorException("Slug behavior disabled on tables with no 'slug' field.");
        }

        parent::__construct($table, $config);
    }
}
