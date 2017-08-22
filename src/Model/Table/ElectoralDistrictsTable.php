<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Database\Connection;
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
        $this->hasMany('Children', [
            'className' => self::class,
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Contests');
        $this->hasMany('Elections');
        $this->hasMany('Offices');
        $this->belongsTo('DistrictTypes', ['foreignKey' => 'type_id']);
        $this->belongsTo('Parents', [
            'className' => self::class,
            'foreignKey' => 'parent_id'
        ]);
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
