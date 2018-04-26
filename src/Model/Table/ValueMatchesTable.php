<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use ArrayObject;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface as Entity;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\ValueMatch;
use OurSociety\Validation\Validator as AppValidator;

/**
 * ValueMatches Model
 *
 * @property CitizensTable|Association\BelongsTo $Citizens
 * @property PoliticiansTable|Association\BelongsTo $Politicians
 * @property CategoriesTable|Association\BelongsTo $Categories
 *
 * @method ValueMatch get($primaryKey, $options = [])
 * @method ValueMatch newEntity($data = null, array $options = [])
 * @method ValueMatch[] newEntities(array $data, array $options = [])
 * @method ValueMatch|bool save(Entity $entity, $options = [])
 * @method ValueMatch patchEntity(Entity $entity, array $data, array $options = [])
 * @method ValueMatch[] patchEntities($entities, array $data, array $options = [])
 * @method ValueMatch findOrCreate($search, callable $callback = null, $options = [])
 */
class ValueMatchesTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Citizens', ['className' => UsersTable::class]);
        $this->belongsTo('Politicians', ['className' => UsersTable::class]);
        $this->belongsTo('Categories');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // match
            //->decimal('match') // TODO: Error validating
            ->notEmpty('match')
            ->requirePresence('match', 'create')
            // match
            //->decimal('match') // TODO: Error validating
            // error_percentage
            //->decimal('error_percentage') // TODO: Error validating
            // sample_size
            ->integer('sample_size')
            ->notEmpty('sample_size')
            ->requirePresence('sample_size', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            //->add($rules->existsIn(['citizen_id'], 'Citizens'))
            //->add($rules->existsIn(['politician_id'], 'Politicians'))
            ->add($rules->existsIn(['category_id'], 'Categories'))
            ->add($rules->isUnique(['citizen_id', 'politician_id', 'category_id'], [
                'allowMultipleNulls' => false,
                'message' => 'Only one match per citizen/politician/category pair (plus one row with null category).'
            ]));
    }

    public function afterSave(Event $event, ValueMatch $entity, ArrayObject $options): void
    {
        if ($entity->category_id !== null) {
            $this->updateTotalValueMatchForUserPair($entity);
        }
    }

    private function updateTotalValueMatchForUserPair(ValueMatch $entity): void
    {
        $updateSampleSizeAcrossAllMatches = function () use ($entity) {
            $conditions = [
                'id IS NOT' => $entity->id,
                'citizen_id' => $entity->citizen_id,
                'politician_id' => $entity->politician_id,
            ];

            $errorPercentage = $entity->sample_size > 0 ? 1 / $entity->sample_size * 100 : 100;
            $expression = new QueryExpression(sprintf('GREATEST(match - %s, 0)', $errorPercentage));
            $commonData = [
                'match' => $expression,
            ];

            $this->updateAll($commonData, $conditions);
        };

        $updateTotalForAllCategories = function () use ($entity) {
            $query = $this->find();
            $matchPercentage = $query
                ->select(['match' => $query->func()->avg('match')])->where([
                    'citizen_id' => $entity->citizen_id,
                    'politician_id' => $entity->politician_id,
                    'category_id IS NOT' => null,
                ])
                ->extract('match')->first();

            $data = [
                'citizen_id' => $entity->citizen_id,
                'politician_id' => $entity->politician_id,
                'category_id' => null,
                'sample_size' => $entity->sample_size,
                'match' => $matchPercentage,
            ];

            try {
                $existing = $this->find()->select(['id'])->where([
                    'citizen_id' => $entity->citizen_id,
                    'politician_id' => $entity->politician_id,
                    'category_id IS' => null,
                ])->firstOrFail();
                $total = $this->patchEntity($existing, $data);
            } catch (RecordNotFoundException $exception) {
                $total = $this->newEntity($data);
            }

            $this->saveOrFail($total);
        };

        $updateSampleSizeAcrossAllMatches();
        $updateTotalForAllCategories();
    }
}
