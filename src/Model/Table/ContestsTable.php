<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;

/**
 * ContestsTable.
 *
 * @property HasMany|CandidatesTable $Candidates
 * @property BelongsTo|ElectionsTable $Elections
 * @property BelongsTo|ElectoralDistrictsTable $ElectoralDistricts
 * @property BelongsTo|OfficesTable $Offices
 * @property BelongsTo|VoteVariationsTable $VoteVariations
 */
class ContestsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->hasMany('Candidates');
        $this->belongsTo('Elections');
        $this->belongsTo('ElectoralDistricts');
        $this->belongsTo('Offices');
        $this->belongsTo('VoteVariations');
    }
}
