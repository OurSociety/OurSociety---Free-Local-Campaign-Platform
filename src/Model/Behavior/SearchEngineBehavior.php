<?php
declare(strict_types=1);

namespace OurSociety\Model\Behavior;

use Cake\ORM\Behavior;

class SearchEngineBehavior extends Behavior
{
    protected $_defaultConfig = [
        'finder' => 'all',
    ];

    public function getSearchFinder(): string
    {
        return $this->getConfig('finder');
    }
}
