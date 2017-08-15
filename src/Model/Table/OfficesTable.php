<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\BelongsTo;

/**
 * OfficesTable.
 *
 * @property BelongsTo|ElectoralDistrictsTable $ElectoralDistricts
 */
class OfficesTable extends AppTable
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
