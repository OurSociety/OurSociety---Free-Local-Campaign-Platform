<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use OurSociety\View\AppView;

/**
 * Election Entity
 *
 * @property string $id
 * @property string $slug
 * @property string $name
 * @property string $date
 * @property string $election_type
 * @property string $state_id
 * @property string $is_state_wide
 * @property string $registration_info
 * @property string $absentee_ballot_info
 * @property string $results_uri
 * @property string $hours_open_id
 * @property string $has_election_day_registration
 * @property string $registration_deadline
 * @property string $absentee_request_deadline
 * @property string $electoral_district_id
 *
 * @property Entity $state
 * @property Contest[] $contests
 * @property ElectoralDistrict[] $electoral_district
 */
class Election extends AppEntity
{
    public function renderLink(AppView $view, $url = null): string
    {
        return $view->Html->link($this->name, $url ?: ['_name' => 'election', 'election' => $this->slug]);
    }
}
