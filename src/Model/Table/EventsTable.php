<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\BelongsTo;

/**
 * EventsTable.
 *
 * @property BelongsTo|ElectoralDistrictsTable $ElectoralDistricts
 */
class EventsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('ElectoralDistricts');
    }
}
