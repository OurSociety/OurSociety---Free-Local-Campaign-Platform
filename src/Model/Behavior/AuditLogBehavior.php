<?php
declare(strict_types=1);

namespace OurSociety\Model\Behavior;

use AuditStash\Model\Behavior as AuditStash;
use OurSociety\Model\Table\AppTable;

class AuditLogBehavior extends AuditStash\AuditLogBehavior
{
    /**
     * {@inheritdoc}
     */
    public function __construct(AppTable $table, array $config = [])
    {
        if ($table->getAlias() === 'Audits') {
            throw new DisableBehaviorException("AuditLog behavior disabled on 'audits' table to prevent infinite loops.");
        }

        parent::__construct($table, $config);

        if ($table->getAlias() === 'Users') {
            $this->blacklistField('last_seen'); // Prevents audit log on every authenticated page load.
        }
    }

    private function blacklistField(string $fieldName): void
    {
        $this->setConfig('blacklist', [$fieldName]);
    }
}
