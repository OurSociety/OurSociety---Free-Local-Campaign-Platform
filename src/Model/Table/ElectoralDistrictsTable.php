<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Association;
use Cake\ORM\Query;
use OurSociety\Model\Behavior\SearchEngineBehavior;

/**
 * ElectoralDistrictsTable.
 *
 * @property Association\BelongsTo|DistrictTypesTable $DistrictTypes
 * @property Association\BelongsTo|ElectoralDistrictsTable $Counties
 * @property Association\BelongsTo|ElectoralDistrictsTable $Parents
 * @property Association\BelongsTo|ElectoralDistrictsTable $States
 * @property Association\HasMany|ArticlesTable $Articles
 * @property Association\HasMany|ElectoralDistrictsTable $Children
 * @property Association\HasMany|ContestsTable $Contests
 * @property Association\HasMany|UsersTable $ElectedOfficials
 * @property Association\HasMany|ElectionsTable $Elections
 * @property Association\HasMany|EventsTable $Events
 * @property Association\HasMany|OfficesTable $Offices
 * @property Association\HasMany|UsersTable $PathwayPoliticians
 * @property Association\HasMany|PoliticianVideosTable $Videos
 * @property Association\HasOne|UsersTable $Mayors
 * @property Association\HasOne|ElectionsTable $UpcomingElections
 *
 * @method Query findByIdOcd(string $ocdId)
 */
class ElectoralDistrictsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior(SearchEngineBehavior::class);
        $this->setDisplayField('label');
        $this->belongsTo('Counties', ['className' => self::class])->setForeignKey('county_id');
        $this->belongsTo('DistrictTypes')->setForeignKey('type_id');
        $this->belongsTo('Parents', ['className' => self::class])->setForeignKey('parent_id');
        $this->belongsTo('States', ['className' => self::class])->setForeignKey('state_id');
        $this->hasMany('Articles', ['className' => ArticlesTable::class])->setFinder('forCitizen');
        $this->hasMany('Children', ['className' => self::class])->setForeignKey('parent_id');
        $this->hasMany('Contests');
        $this->hasMany('ElectedOfficials', ['className' => UsersTable::class])->setFinder('isElectedOfficial');
        $this->hasMany('Elections');
        $this->hasMany('Events');
        $this->hasMany('Offices');
        $this->hasMany('CommunityContributors', ['className' => UsersTable::class])->setFinder('isCommunityContributor');
        $this->hasMany('Videos', ['className' => PoliticianVideosTable::class]);
        $this->hasOne('Mayors', ['className' => UsersTable::class])->setFinder('isMayor')->setStrategy('select');
        $this->hasOne('UpcomingElections', ['className' => ElectionsTable::class])->setFinder('upcoming');
    }

    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary): void
    {
        if (count($query->clause('select')) > 0) {
            return;
        }

        $query
            ->enableAutoFields()
            ->select(array_diff($this->getSchema()->columns(), ['polygon']));

        //if ($primary === true) {
        $aliasedField = $query->repository()->aliasField('polygon');
        $underscoredAliasedField = str_replace('.', '__', $aliasedField);
        $polygonAsGeoJSON = $query->newExpr(sprintf('ST_AsGeoJSON(%s)', $aliasedField));

        $query->select([$underscoredAliasedField => $polygonAsGeoJSON]);
        //}
    }

    public function getArticlesBySlug(string $slug)
    {
        return $this->Articles->find('forCitizen')
            ->matching('ElectoralDistricts', function (Query $query) use ($slug) {
                return $query->find('slugged', ['slug' => $slug]);
            });
    }

    protected function getDefaultOrder(): array
    {
        return [
            'callback' => function (Query $query) {
                $query->order([
                    (string)$query->repository()->aliasField('type_id') => 'ASC',
                    (string)$query->repository()->aliasField('number') => 'ASC',
                    (string)$query->repository()->aliasField('name') => 'ASC',
                ]);
            },
        ];
    }
}
