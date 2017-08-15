<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;

/**
 * ElectionsTable.
 *
 * @property HasMany|ContestsTable $Contests
 * @property BelongsTo|StatesTable $States
 * @property BelongsTo|ElectoralDistrictsTable $ElectoralDistricts
 */
class ElectionsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Contests');
        $this->belongsTo('States');
        $this->belongsTo('ElectoralDistricts');
    }
}
