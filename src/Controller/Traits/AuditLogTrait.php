<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

use AuditStash\Meta\RequestMetadata;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\Table;

trait AuditLogTrait
{
    protected function setupAuditLog(): void
    {
        /** @var ComponentRegistry $components */
        $components = $this->components();
        $authComponent = $components->get('Auth');

        /** @var string|null $userId */
        $userId = $authComponent ? $authComponent->user('id') : null;
        $requestMetadata = new RequestMetadata($this->request, $userId);

        /** @var Table $table */
        $table = $this->loadModel();
        $table->eventManager()->on($requestMetadata);
    }
}
