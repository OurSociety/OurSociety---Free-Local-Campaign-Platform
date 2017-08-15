<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\BelongsTo;

/**
 * CandidatesTable.
 *
 * @property BelongsTo|ContestsTable $Contests
 * @property BelongsTo|UsersTable $Politicians
 * @property BelongsTo|AppTable $CandidatePreElectionStatuses
 * @property BelongsTo|AppTable $CandidatePostElectionStatuses
 */
class CandidatesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Contests');
        $this->belongsTo('Politician', ['className' => UsersTable::class])->setForeignKey('politician_id');
        $this->belongsTo('CandidatePreElectionStatuses')->setForeignKey('pre_election_status_id');
        $this->belongsTo('CandidatePostElectionStatuses')->setForeignKey('post_election_status_id');
    }
}
