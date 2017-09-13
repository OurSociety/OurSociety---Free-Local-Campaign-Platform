<?php
declare(strict_types = 1);

namespace OurSociety\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Faker\Factory as Example;
use OurSociety\View\AppView;

/**
 * User Entity
 *
 * @property string $id The UUID.
 * @property string $slug The slug.
 * @property string $level The current level of user.
 * @property string $email The email address.
 * @property string $email_temp The temporary email address for imported candidates.
 * @property string $position The position for politicians.
 * @property int $electoral_district_id The electoral district ID.
 * @property int $incumbent True if currently in office, false otherwise.
 * @property int $zip The zip code.
 * @property string $phone The phone number.
 * @property string $password The password.
 * @property string $name The name.
 * @property string|null $token The verification token.
 * @property \Cake\I18n\FrozenTime|null $token_expires The expiry timestamp.
 * @property \Cake\I18n\FrozenTime|null $verified The email verification timestamp.
 * @property string $role The role.
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
 * @property PoliticianAward[] $awards
 * @property PoliticianPosition[] $positions
 * @property PoliticianQualification[] $qualifications
 * @property PoliticianVideo[] $videos
 * @property ValueMatch[] $politician_matches
 * @property ValueMatch[] $value_matches
 *
 * @property int|null $age The age, if `born` date available.
 * @property PoliticianVideo|null $featured_video
 * @property OfficeType $office_type
 * @property bool $is_example
 */
class User extends AppEntity
{
    public const ROLES = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];
    public const ROLES_LABELS = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CITIZEN = 'citizen';
    public const ROLE_POLITICIAN = 'politician';
    public const TOKEN_LENGTH = 6;
    public const TOKEN_EXPIRY_HOURS = 24;
    public const COUNTRIES = [
        'US' => 'United States of America',
    ];
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

    /**
     * Has onboarded?
     *
     * Determines if a user has completed the tutorial/onboarding process.
     *
     * @return bool True if location set, false otherwise.
     */
    public function hasOnboarded(): bool
    {
        return $this->electoral_district !== null;
    }

    public function isInMunicipality(ElectoralDistrict $municipality): bool
    {
        return $this->electoral_district->equals($municipality);
    }

    /**
     * Is token expired?
     *
     * @return bool True if token has expired, false otherwise.
     */
    public function isTokenExpired(): bool
    {
        $expires = $this->token_expires ?? Time::now();

        return $expires->lte(Time::now());
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
        $table->removeBehavior('CounterCache');
        $table->removeBehavior('Timestamp');
        $table->saveOrFail($user);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCitizen(): bool
    {
        return $this->role === self::ROLE_CITIZEN;
    }

    public function isPathwayPolitician(): bool
    {
        return $this->isCitizen() && $this->pathway_politician;
    }

    public function isPolitician(): bool
    {
        return $this->role === self::ROLE_POLITICIAN;
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

    protected function _getAge(): ?int
    {
        return $this->born !== null ? $this->born->diffInYears(Time::now()) : null;
    }

    protected function _getLevel(): ?int
    {
        return 1;
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
        return mb_strlen($password) > 0
            ? (new DefaultPasswordHasher)->hash($password)
            : null;
    }
}
