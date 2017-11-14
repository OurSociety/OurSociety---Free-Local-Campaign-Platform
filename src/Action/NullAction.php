<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Http\Response;

abstract class NullAction extends Action
{
    public function __invoke(...$params): ?Response
    {
        return null;
    }
}
