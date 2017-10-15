<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class AddElections extends AbstractMigration
{
    public function up(): void
    {
        $this->table('candidate_post_election_statuses', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('id_vip', 'string', [
                'default' => '',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('candidate_pre_election_statuses', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('id_vip', 'string', [
                'default' => '',
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('candidates', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('contest_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('politician_id', 'uuid', [
                'comment' => 'Reference to a Person element with additional information about the candidate.',
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_incumbent', 'boolean', [
                'comment' => 'Indicates whether the candidate is the incumbent for the office associated with the contest.	',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('pre_election_status_id', 'uuid', [
                'comment' => 'Registration status of the candidate (e.g. filed, qualified, etc...).	',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('post_election_status_id', 'uuid', [
                'comment' => 'Final status of the candidate (e.g. winner, withdrawn, etc...).	',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('ballot_name', 'string', [
                'comment' => 'The candidate’s name as it will be displayed on the official ballot (e.g. “Ken T. Cuccinelli II”).	',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('file_date', 'date', [
                'comment' => 'Date when the candidate filed for the contest.',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_top_ticket', 'boolean', [
                'comment' => 'Indicates whether the candidate is the top of a ticket that includes multiple candidates.	',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('party_id', 'uuid', [
                'comment' => 'Reference to a Party element with additional information about the candidate’s affiliated party. This is the party affiliation that is intended to be presented as part of ballot information.	',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('contests', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('office_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'comment' => 'Name of the contest, not necessarily how it appears on the ballot (NB: BallotTitle should be used for this purpose).',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('abbreviation', 'string', [
                'comment' => 'An abbreviation for the contest.',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('number_elected', 'integer', [
                'comment' => 'Number of candidates that are elected in the contest (i.e. “N” of N-of-M).',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('votes_allowed', 'integer', [
                'comment' => 'Maximum number of votes/write-ins per voter in this contest.',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('ballot_sub_title', 'string', [
                'comment' => 'Subtitle of the contest as it appears on the ballot.',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('ballot_title', 'string', [
                'comment' => 'Title of the contest as it appears on the ballot.',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('election_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('electoral_district_id', 'string', [
                'comment' => 'References an ElectoralDistrict element that represents the geographical scope of the contest.	',
                'default' => null,
                'limit' => 36,
                'null' => true,
            ])
            ->addColumn('electorate_specification', 'string', [
                'comment' => 'Specifies any changes to the eligible electorate for this contest past the usual, “all registered voters” electorate. This subtag will most often be used for primaries and local elections. In primaries, voters may have to be registered as a specific party to vote, or there may be special rules for which ballot a voter can pull. In some local elections, non-citizens can vote.	',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('has_rotation', 'boolean', [
                'comment' => 'Indicates whether the selections in the contest are rotated.	',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('sequence_order', 'integer', [
                'comment' => 'Order in which the contests are listed on the ballot. This is the default ordering, and can be overrides by data in a BallotStyle element.	',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('vote_variation_id', 'uuid', [
                'comment' => 'Vote variation associated with the contest (e.g. n-of-m, majority, et al).',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('district_types', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('id_vip', 'string', [
                'comment' => 'Name in Voting Information Project specification',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('id_gapi_scope', 'string', [
                'comment' => 'Scope in Google Civic Data API (https://developers.google.com/civic-information/docs/v2/elections/voterInfoQuery)',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('elections', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'comment' => 'The name for the election.',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('date', 'date', [
                'comment' => 'Specifies when the election is being held. The Date is considered to be in the timezone local to the state holding the election.	',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('election_type', 'string', [
                'comment' => 'Specifies the highest controlling authority for election (e.g., federal, state, county, city, town, etc.)	',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state_id', 'uuid', [
                'comment' => 'Specifies a link to the State element where the election is being held.	',
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_state_wide', 'boolean', [
                'comment' => 'Indicates whether the election is statewide.',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('registration_info', 'string', [
                'comment' => 'Specifies information about registration for this election either as text or a URI.	',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('absentee_ballot_info', 'string', [
                'comment' => 'Specifies information about requesting absentee ballots either as text or a URI.',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('results_uri', 'string', [
                'comment' => 'Contains a URI where results for the election may be found.',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('hours_open_id', 'uuid', [
                'comment' => 'References the HoursOpen element, which lists the hours of operation for polling locations.',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('has_election_day_registration', 'boolean', [
                'comment' => 'Specifies if a voter can register on the same day of the election (i.e., the last day of the election).',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('registration_deadline', 'date', [
                'comment' => 'Specifies the last day to register for the election with the possible exception of Election Day registration.',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('absentee_request_deadline', 'date', [
                'comment' => 'Specifies the last day to request an absentee ballot.',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('electoral_district_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('electoral_districts', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('parent_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('id_ocd', 'string', [
                'comment' => 'Open Civic Data Division Identifier',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('id_local', 'string', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addColumn('id_geoid', 'string', [
                'comment' => 'United States Census Bureau geographic identifier',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('id_affgeoid', 'string', [
                'comment' => 'The American FactFinder (AFF)',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('id_gnis', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => true,
            ])
            ->addColumn('id_census2010', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'comment' => 'Specifies the electoral area’s name.',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('number', 'integer', [
                'comment' => 'Specifies the district number of the district (e.g. 34, in the case of the 34th State Senate District).',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('type_id', 'uuid', [
                'comment' => 'Specifies the type of electoral area.',
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('office_count', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('subdivision_count', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('sibling_count', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('polygon', 'geometry', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'id_affgeoid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id_census2010',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id_geoid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id_gnis',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id_local',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id_ocd',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'parent_id',
                    'type_id',
                    'number',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('external_identifiers', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('table', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('record_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('type_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('value', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('identifier_types', ['id' => false, 'primary_key' => ['uuid']])
            ->addColumn('uuid', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tag', 'string', [
                'default' => '',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('vip_spec', 'integer', [
                'default' => '0',
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('incumbencies', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('seat_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('politician_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('start', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('end', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('offices', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('electoral_district_id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('states', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'comment' => 'Specifies the name of a state, such as Alabama.	',
                'default' => '',
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('election_administration_id', 'uuid', [
                'comment' => 'Links to the state’s election administration object.	',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('vote_variations', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'comment' => 'http://vip-specification.readthedocs.io/en/release/built_rst/xml/enumerations/vote_variation.html#multi-xml-vote-variation',
                'default' => '',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('vip_spec', 'boolean', [
                'comment' => 'True if VoteVariation name/tag is from VIP Specification.',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('electoral_district_id', 'uuid', [
                'after' => 'zip',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('users')
            ->removeColumn('electoral_district_id')
            ->update();

        $this->dropTable('candidate_post_election_statuses');
        $this->dropTable('candidate_pre_election_statuses');
        $this->dropTable('candidates');
        $this->dropTable('contests');
        $this->dropTable('district_types');
        $this->dropTable('elections');
        $this->dropTable('electoral_districts');
        $this->dropTable('external_identifiers');
        $this->dropTable('identifier_types');
        $this->dropTable('incumbencies');
        $this->dropTable('offices');
        $this->dropTable('states');
        $this->dropTable('vote_variations');
    }
}
