<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\I18n\Date;

/**
 * Candidate Entity
 *
 * @property string id
 * @property string contest_id
 * @property string politician_id Reference to a Person element with additional information about the candidate.
 * @property bool is_incumbent Indicates whether the candidate is the incumbent for the office associated with the
 *     contest.
 * @property string pre_election_status_id Registration status of the candidate (e.g. filed, qualified, etc...).
 * @property string post_election_status_id Final status of the candidate (e.g. winner, withdrawn, etc...).
 * @property string ballot_name The candidate’s name as it will be displayed on the official ballot (e.g. “Ken T.
 *     Cuccinelli II”).
 * @property Date file_date Date when the candidate filed for the contest.
 * @property bool is_top_ticket Indicates whether the candidate is the top of a ticket that includes multiple
 *     candidates.
 * @property string party_id Reference to a Party element with additional information about the candidate’s affiliated
 *     party. This is the party affiliation that is intended to be presented as part of ballot information.
 *
 * @property Contest $contest
 * @property User $politician
 * @property AppEntity $candidate_pre_election_status
 * @property AppEntity $candidate_post_election_status
 */
class Candidate extends AppEntity
{
    public function getIcon(): string
    {
        return 'user-plus';
    }
}
