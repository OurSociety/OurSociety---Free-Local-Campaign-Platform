<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Contest Entity
 *
 * @property string $id
 * @property string $slug
 * @property string $name Name of the contest, not necessarily how it appears on the ballot (NB: BallotTitle should be used for this purpose).
 * @property string $abbreviation An abbreviation for the contest.
 * @property bool $number_elected Number of candidates that are elected in the contest (i.e. “N” of N-of-M).
 * @property bool $votes_allowed Maximum number of votes/write-ins per voter in this contest.
 * @property string $ballot_sub_titled Subtitle of the contest as it appears on the ballot.
 * @property string $ballot_titled Title of the contest as it appears on the ballot.
 * @property string $election_id
 * @property string $electoral_district_id References an ElectoralDistrict element that represents the geographical scope of the contest.
 * @property string $electorate_specification Specifies any changes to the eligible electorate for this contest past the usual, “all registered voters” electorate. This subtag will most often be used for primaries and local elections. In primaries, voters may have to be registered as a specific party to vote, or there may be special rules for which ballot a voter can pull. In some local elections, non-citizens can vote.
 * @property bool $has_rotation Indicates whether the selections in the contest are rotated.
 * @property int $sequence_order Order in which the contests are listed on the ballot. This is the default ordering, and can be overrides by data in a BallotStyle element.
 * @property string $vote_variation_id Vote variation associated with the contest (e.g. n-of-m, majority, et al).
 *
 * @property Candidate[] $candidates
 * @property Office $office
 * @property Election $election
 * @property ElectoralDistrict $electoral_district
 */
class Contest extends AppEntity
{
}
