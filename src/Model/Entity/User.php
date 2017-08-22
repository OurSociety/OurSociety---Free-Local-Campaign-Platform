<?php
declare(strict_types = 1);

namespace OurSociety\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
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
 * @property RecordSet|PoliticianArticle[] $articles
 * @property RecordSet|PoliticianAwards[] $awards
 * @property RecordSet|PoliticianPosition[] $positions
 * @property RecordSet|PoliticianQualification[] $qualifications
 * @property RecordSet|PoliticianVideo[] $videos
 * @property ValueMatch[] $politician_matches
 * @property ValueMatch[] $value_matches
 *
 * @property int|null $age The age, if `born` date available.
 * @property PoliticianVideo|null $featured_video
 */
class User extends AppEntity
{
    public const ROLES = [self::ROLE_ADMIN, self::ROLE_CITIZEN, self::ROLE_POLITICIAN];
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

    public function isPolitician(): bool
    {
        return $this->role === self::ROLE_POLITICIAN;
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
