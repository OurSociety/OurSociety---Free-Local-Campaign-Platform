<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Search;

use Search\Manager;

interface Search
{
    public function __invoke(Manager $manager): Manager;
}
