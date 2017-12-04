<?php
declare(strict_types=1);

namespace OurSociety\Action\Traits;

use Cake\Datasource\EntityInterface;
use Cake\Network\Exception\BadRequestException;
use Cake\ORM\Query;
use OurSociety\Action\Action;
use OurSociety\Model\Model;

trait RecordIdentifierAwareTrait
{
    protected function getRecordIdentifier($params): string
    {
        if ($this->hasRecordIdentifier($params) === false) {
            throw new BadRequestException('Missing record identifier');
        }

        return $params[0];
    }

    protected function hasRecordIdentifier($params): bool
    {
        return is_string($params[0] ?? null);
    }

    protected function getRecord(string $identifier): EntityInterface
    {
        return $this->getQuery($identifier)->firstOrFail();
    }

    protected function getQuery(string $identifier): Query
    {
        /** @var Model $model */
        $model = $this->getModel();
        /** @var Action $action */
        $action = $this;

        return $model->getQueryForAction($action, $this->getDefaultFinderOptions($identifier));
    }

    protected function getDefaultFinderOptions(string $identifier): array
    {
        return [
            'identifier' => $identifier,
            'identity' => $this->hasIdentity() ? $this->getIdentity() : null,
        ];
    }
}
