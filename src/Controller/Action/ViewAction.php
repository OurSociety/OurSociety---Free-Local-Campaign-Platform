<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Crud\Action as Crud;

class ViewAction extends Crud\ViewAction
{
    use Traits\FindMethodTrait;
}
