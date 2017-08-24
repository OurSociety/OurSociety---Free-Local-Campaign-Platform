<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;

/**
 * ElectoralDistrictsTable.
 *
 * @property HasMany|ElectoralDistrictsTable $Children
 * @property HasMany|ContestsTable $Contests
 * @property HasMany|ElectionsTable $Elections
 * @property HasMany|OfficesTable $Offices
 * @property BelongsTo|DistrictTypesTable $DistrictTypes
 * @property BelongsTo|ElectoralDistrictsTable $Parents
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

        $this->setDisplayField('label');
        $this->belongsTo('Counties', ['className' => self::class])->setForeignKey('county_id');
        $this->belongsTo('DistrictTypes')->setForeignKey('type_id');
        $this->belongsTo('Parents', ['className' => self::class])->setForeignKey('parent_id');
        $this->belongsTo('States', ['className' => self::class])->setForeignKey('state_id');
        $this->hasMany('Articles', ['className' => PoliticianArticlesTable::class]);
        $this->hasMany('Children', ['className' => self::class])->setForeignKey('parent_id');
        $this->hasMany('Contests');
        $this->hasMany('ElectedOfficials', ['className' => UsersTable::class])->setFinder('isElectedOfficial');
        $this->hasMany('Elections');
        $this->hasMany('Events');
        $this->hasMany('Offices');
        $this->hasMany('PathwayPoliticians', ['className' => UsersTable::class])->setFinder('isPathwayPolitician');
        $this->hasMany('Videos', ['className' => PoliticianVideosTable::class]);
        $this->hasOne('UpcomingElections', ['className' => ElectionsTable::class])->setFinder('upcoming');
        $this->hasOne('Mayors', ['className' => UsersTable::class])->setFinder('isMayor')->setStrategy('select');
    }

    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary): void
    {
        $query
            ->enableAutoFields()
            ->select(array_diff($this->getSchema()->columns(), ['polygon']));

        if ($primary === true) {
            $aliasField = $query->repository()->aliasField('polygon');
            $query->select([
                str_replace('.', '__', $aliasField) => $query->newExpr(sprintf('ST_AsGeoJSON(%s)', $aliasField))
            ]);
        }
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
            }
        ];
    }

    protected function findMunicipality(Query $query, array $options): Query
    {
        return $query->matching('DistrictTypes', function (Query $query) {
            return $query->where(['DistrictTypes.id_vip' => 'municipality']);
        });
    }
}
