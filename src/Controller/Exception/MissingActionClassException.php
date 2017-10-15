<?php
declare(strict_types=1);

namespace OurSociety\Controller\Exception;

use Cake\Core\Exception\Exception;

/**
 * Missing Action Class exception - used when a controller action class cannot be found.
 */
class MissingActionClassException extends Exception
{
    public function __construct(string $actionClassName)
    {
        $this->_messageTemplate = 'Action class %s could not be found.';

        parent::__construct(compact('actionClassName'), 404);
    }
}
