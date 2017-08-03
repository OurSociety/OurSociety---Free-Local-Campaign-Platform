<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

/**
 * Answer Entity
 *
 * @property string $id The transaction ID.
 * @property string $transaction The transaction ID.
 * @property \Cake\I18n\FrozenTime $created The created timestamp.
 * @property string $type The update type (one of 'create', 'update', 'delete').
 * @property string $source_key The ID of the source (table) that this entry is about.
 * @property string $source The name of the source (table) that this entry is about.
 * @property string $parent_source The name of the parent source (table) that triggered the change.
 * @property string $original The JSON representation of record fields before they were changed.
 * @property string $changed The JSON representation of record fields after they were changed.
 * @property string $meta The JSON representation of metadata about the change (request information, etc.)
 */
class Audit extends Entity
{
    /**
     * Get transaction ID.
     *
     * We retrieve this from 'id' field instead of 'transaction' field.
     *
     * @return string|null The transaction ID, if set.
     */
    protected function _getTransaction(): ?string
    {
        return $this->_properties['id'] ?? null;
    }

    /**
     * Set transaction ID.
     *
     * We store this in 'id' field instead of 'transaction' field.
     *
     * @param string $id The transaction ID.
     */
    protected function _setTransaction(string $id): void
    {
        $this->_properties['id'] = $id;
    }
}
