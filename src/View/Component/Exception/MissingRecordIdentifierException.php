<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Exception;

use Cake\Core\Exception\Exception;
use Cake\ORM\Entity;

class MissingRecordIdentifierException extends Exception
{
    /**
     * Constructor.
     *
     * @param Entity $record
     * @param \Exception|null $previous the previous exception.
     */
    public function __construct(Entity $record, \TypeError $previous)
    {
        $this->_messageTemplate = 'Record identifier not found. Did you fetch the slug (or ID) in your query? Record: %s';

        parent::__construct([
            'record' => $record,
        ], 404, $previous);
    }
}
