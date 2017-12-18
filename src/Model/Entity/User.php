<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\Utility\Text;
use Faker\Factory as Example;
use Muffin\Slug\Slugger\CakeSlugger;
use OurSociety\Model\Behavior\CounterCacheBehavior;
use OurSociety\ORM\TableRegistry;
use OurSociety\View\AppView;
use OurSociety\View\Cell\Profile\PictureCell;
use OurSociety\View\Component\Field;

/**
 * User Entity.
 *
 * @property string $id The UUID.
 * @property string $slug The slug.
 * @property string $email The email address.
 * @property string $email_temp The temporary email address for imported candidates.
 * @property string $position The position for politicians.
 * @property int $electoral_district_id The electoral district ID.
 * @property bool $incumbent True if currently in office, false otherwise.
 * @property bool $community_contributor True if citizen is a community contributor, false otherwise.
 * @property int $zip The zip code.
 * @property string $phone The phone number.
 * @property string $password The password.
 * @property string $name The name.
 * @property string|null $token The verification token.
 * @property \Cake\I18n\FrozenTime|null $token_expires The expiry timestamp.
 * @property \Cake\I18n\FrozenTime|null $verified The email verification timestamp.
 * @property string $role The role.
 * @property null|string $plan The current ChargeBee plan ID.
 * @property int $level The current level of user.
 * @property int $answer_count The amount of questions answered.
 * @property string|null $picture The profile picture.
 * @property string|null $address_1 The first address line.
 * @property string|null $address_2 The second address line.
 * @property string|null $city The current city.
 * @property string|null $state The current state.
 * @property string|null $birth_name The birth name.
 * @property string|null $birth_city The birth city.
 * @property string|null $birth_state The birth state.
 * @property string|null $birth_country The birth country.
 * @property \Cake\I18n\FrozenDate|null $born The date of birth.
 * @property \Cake\I18n\FrozenTime|null $last_seen The last time the user logged in.
 * @property \Cake\I18n\FrozenTime $created The created timestamp.
 * @property \Cake\I18n\FrozenTime $modified The modified timestamp.
 *
 * @property Answer $answers
 * @property Category[] $categories
 * @property ElectoralDistrict $electoral_district
 * @property Article[] $articles
 * @property Notification[] $notifications
 * @property Award[] $awards
 * @property Position[] $positions
 * @property Qualification[] $qualifications
 * @property Video[] $videos
 * @property ValueMatch[] $politician_matches
 * @property ValueMatch[] $value_matches
 *
 * @property int|null $age The age, if `born` date available.
 * @property Video|null $featured_video
 * @property OfficeType $office_type
 * @property bool $is_example
 * @property string $level_name The name of the current level.
 * @property string $level_badge_url The badge for the current level.
 */
class User extends AppEntity implements SearchableEntity
{
    use Traits\SearchableTrait;

    public const COUNTRIES = [
        'US' => 'United States of America',
    ];

    private const LEVEL_NAMES = [
        1 => 'Citizen',
        2 => 'Member',
        3 => 'Participant',
        4 => 'Informed Voter',
        5 => 'Community Advocate',
        6 => 'Community Champion',
        7 => 'Community Builder',
        8 => 'Thought Leader',
        9 => 'Visionary Citizen',
        10 => 'Enlightened Citizen',
    ];

    private const LEVEL_BADGE_URLS = [
        1 => '/img/svg/badge/01-citizen.svg',
        2 => '/img/svg/badge/02-member.svg',
        3 => '/img/svg/badge/03-participant.svg',
        4 => '/img/svg/badge/04-informed-voter.svg',
        5 => '/img/svg/badge/05-community-advocate.svg',
        6 => '/img/svg/badge/06-community-champion.svg',
        7 => '/img/svg/badge/07-community-builder.svg',
        8 => '/img/svg/badge/08-thought-leader.svg',
        9 => '/img/svg/badge/09-visionary-citizen.svg',
        10 => '/img/svg/badge/10-enlightened-citizen.svg',
    ];

    public const ROLES = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];

    public const ROLES_LABELS = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];

    public const ROLE_ADMIN = 'admin';

    public const ROLE_CITIZEN = 'citizen';

    public const ROLE_POLITICIAN = 'politician';

    public const STATES = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AS' => 'American Samoa',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'Dist. of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'GU' => 'Guam',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MH' => 'Marshall Islands',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'FM' => 'Micronesia',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'MP' => 'Northern Marianas',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PW' => 'Palau',
        'PA' => 'Pennsylvania',
        'PR' => 'Puerto Rico',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'VI' => 'Virgin Islands',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    ];

    public const TOKEN_EXPIRY_HOURS = 24;

    public const TOKEN_LENGTH = 6;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);

        $this->setHidden(['password', 'token']);
    }

    public static function example(array $data = null): self
    {
        $example = Example::create();
        $name = $example->firstName . ' ' . $example->lastName;
        $data = ($data ?? []) + [
                'id' => Text::uuid(),
                'name' => $name,
                'slug' => (new CakeSlugger)->slug($name),
                'office_type' => OfficeType::random(),
                'email' => Text::slug($name, '.') . '@example.com',
                'is_example' => true,
            ];

        return new self($data);
    }

    public function canEditMunicipality(ElectoralDistrict $municipality): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isPolitician() && $this->isInMunicipality($municipality)) {
            return true;
        }

        return false;
    }

    public function getAccountRoute(): array
    {
        return ['_name' => 'billing'];
    }

    public function getCommunityContributorProfileRoute(): array
    {
        return ['_name' => 'community-contributor', 'citizen' => $this->slug];
    }

    public function getExampleCommunityContributorProfileRoute(): array
    {
        return ['_name' => 'community-contributor', 'citizen' => 'ron-rivers'];
    }

    public function getDashboardRoute(string $role = null): array
    {
        return ['_name' => sprintf('%s:dashboard', $role ?? $this->role)];
    }

    public function getLogoutRoute(): array
    {
        return ['_name' => 'users:logout'];
    }

    public function getProfileRoute(): array
    {
        return ['_name' => sprintf('%s:profile', $this->role)];
    }

    public function getPublicProfileRoute(array $params = null): array
    {
        $role = $this->_properties['role'] ?? null;
        $slug = $this->_properties['slug'] ?? null;

        if ($role === null || $slug === null) {
            throw new \RuntimeException('Missing role and/or slug field.');
        }

        /** @noinspection DegradedSwitchInspection */
        switch ($role) {
            case 'politician':
                return ['_name' => 'politician', 'politician' => $slug] + ($params ?? []);
            default:
                return ['_name' => 'community-contributor', 'citizen' => $slug] + ($params ?? []);
        }
    }

    public function getMunicipalityRoute(): array
    {
        $municipality = $this->electoral_district ?? new ElectoralDistrict();

        if ($municipality === null) {
            return ['_name' => 'users:onboarding'];
        }

        return ['action' => 'view', $municipality->slug];
    }

    /**
     * @return Field\FieldList|Field\Field[]
     */
    public function getScaffoldFieldList(): Field\FieldList
    {
        return Field\FieldList::fromArray($this->getModel(), [
            'name' => ['title' => 'Full Name'],
            'role',
            'answer_count' => ['title' => 'Answers'],
            'email',
            'last_seen',
            'verified',
        ]);
    }

    /**
     * Has onboarded?
     *
     * Determines if a user has completed the tutorial/onboarding process.
     *
     * @return bool True if location set, false otherwise.
     */
    public function hasOnboarded(): bool
    {
        $electoralDistrictId = $this->_properties['electoral_district_id'] ?? null;

        return $electoralDistrictId !== null;
    }

    public function isAdmin(): bool
    {
        $role = $this->_properties['role'] ?? self::ROLE_CITIZEN;

        return $role === self::ROLE_ADMIN;
    }

    public function isCitizen(): bool
    {
        $role = $this->_properties['role'] ?? self::ROLE_CITIZEN;

        return $role === self::ROLE_CITIZEN;
    }

    public function isCommunityContributor(): bool
    {
        $isCommunityContributor = $this->_properties['community_contributor'] ?? false;

        return $this->isCitizen() && $isCommunityContributor;
    }

    public function isInMunicipality(ElectoralDistrict $municipality): bool
    {
        $electoralDistrict = $this->electoral_district ?? new ElectoralDistrict();

        return $electoralDistrict->equals($municipality);
    }

    public function isPolitician(): bool
    {
        $role = $this->_properties['role'] ?? self::ROLE_CITIZEN;

        return $role === self::ROLE_POLITICIAN;
    }

    /**
     * Is token expired?
     *
     * @return bool True if token has expired, false otherwise.
     */
    public function isTokenExpired(): bool
    {
        if ($this->token_expires === null) {
            return false;
        }

        return $this->token_expires->isPast();
    }

    public function levelUp(): void
    {
        $user = $this->withNextLevel();

        $table = TableRegistry::get('Users');
        $table->removeBehaviorIfLoaded(CounterCacheBehavior::class);
        $table->removeBehaviorIfLoaded(TimestampBehavior::class);
        $table->saveOrFail($user);
    }

    public function printName(): string
    {
        $isExample = $this->_properties['is_example'] ?? false;
        $name = $this->_properties['name'] ?? __('Unnamed');

        if ($isExample) {
            return __('Your Name Here!');
        }

        return $name;
    }

    public function printPosition(): string
    {
        $position = $this->position ?? __('Unknown Position');

        if ($this->incumbent === false) {
            return __('Candidate for {position}', ['position' => $position]);
        }

        return $position;
    }

    public function renderEmailLink(AppView $view): string
    {
        return $view->Html->email($this->email);
    }

    /**
     * Render link to profile.
     *
     * @param AppView $view The view.
     * @param string|array|null $url The url (if overridden).
     * @return string The HTML link.
     */
    public function renderLink(AppView $view, $url = null): string
    {
        if ($url === null && $this->isPolitician()) {
            return $view->Html->link($this->name, [
                '_name' => 'politician',
                'politician' => $this->slug,
            ]);
        }

        return $this->name;
    }

    /**
     * Seen.
     *
     * Convenience method to set a user as seen, which updated the last_seen timestamp.
     *
     * @return void
     */
    public function seen(): void
    {
        $user = $this->withLastSeen();

        $table = TableRegistry::get('Users');
        $table->removeBehaviorIfLoaded(CounterCacheBehavior::class);
        $table->removeBehaviorIfLoaded(TimestampBehavior::class);
        $table->saveOrFail($user);
    }

    /**
     * With token.
     *
     * Generate `token` and `token_expires` values. Token expires in 24 hours.
     *
     * @return User
     */
    public function withToken(): User
    {
        $user = clone $this;

        $minInteger = '1' . str_repeat('0', self::TOKEN_LENGTH - 1);
        $maxInteger = str_repeat('9', self::TOKEN_LENGTH);
        $randomInteger = (string)random_int((int)$minInteger, (int)$maxInteger);

        /** @noinspection SpellCheckingInspection */
        $user->token = str_pad($randomInteger, self::TOKEN_LENGTH, '0', STR_PAD_LEFT);
        $user->token_expires = Time::now()->addHours(self::TOKEN_EXPIRY_HOURS);

        return $user;
    }

    /**
     *
     * @see PictureCell
     * @param AppView $view
     * @return string
     */
    public function renderProfilePicture(AppView $view, array $options = null): string
    {
        $options = $options ?? [];
        $options += [
            'alt' => __('Profile picture of {user_name}', ['user_name' => $this->name]),
            'class' => ['img-fluid'],
            'style' => 'min-width: 100%',
        ];

        return $view->Html->image($this, $options);
    }

    public function persistPlan($planId): void
    {
        $user = $this->withPlan($planId);

        $table = TableRegistry::get('Users');
        $table->removeBehaviorIfLoaded(CounterCacheBehavior::class);
        $table->removeBehaviorIfLoaded(TimestampBehavior::class);
        $table->saveOrFail($user);
    }

    public function searchableAs(): string
    {
        return 'people';
    }

    public function getIcon(): string
    {
        return 'user';
    }

    public function hasAnsweredQuestions(): bool
    {
        return $this->answer_count > 0;
    }

    public function printUnreadNotificationCount(): int
    {
        return $this->_properties['unread_notification_count'] ?? 0;
    }

    public function getNotificationsRoute(): array
    {
        return ['_name' => sprintf('%s:notifications', $this->role)];
    }

    protected function _getAge(): ?int
    {
        /** @var \Cake\I18n\FrozenDate|null $born */
        $born = $this->_properties['born'] ?? null;

        if ($born === null) {
            return null;
        }

        return $born->diffInYears(Time::now());
    }

    protected function _getLevel(): int
    {
        return $this->_properties['level'] ?? 1;
    }

    protected function _getLevelName(): string
    {
        return self::LEVEL_NAMES[$this->level];
    }

    protected function _getLevelBadgeUrl(): string
    {
        return self::LEVEL_BADGE_URLS[$this->level];
    }

    /**
     * Set password mutator.
     *
     * Automatically hashes password if not empty.
     *
     * @param string|null $password The plain text password.
     * @return string|null The hashed password.
     */
    protected function _setPassword(?string $password): ?string
    {
        return mb_strlen($password) > 0 ? (new DefaultPasswordHasher)->hash($password) : null;
    }

    private function withNextLevel()
    {
        $user = clone $this;
        ++$user->level;

        return $user;
    }

    /**
     * With last seen.
     *
     * Populates `last_seen` value with current time.
     *
     * @return User
     */
    private function withLastSeen(): User
    {
        $user = clone $this;
        $user->last_seen = Time::now();

        return $user;
    }

    private function withPlan(?string $planId = null): self
    {
        $user = clone $this;
        $user->plan = $planId;

        return $user;
    }
}
