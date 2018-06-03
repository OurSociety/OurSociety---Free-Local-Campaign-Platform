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
            // true_match_percentage
            //->decimal('true_match_percentage') // TODO: Error validating
            ->notEmpty('true_match_percentage')
            ->requirePresence('true_match_percentage', 'create')
            // match_percentage
            //->decimal('match_percentage') // TODO: Error validating
            ->notEmpty('match_percentage')
            ->requirePresence('match_percentage', 'create')
            // error_percentage
            //->decimal('error_percentage') // TODO: Error validating
            ->notEmpty('error_percentage')
            ->requirePresence('error_percentage', 'create')
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

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options): void
    {
        parent::beforeMarshal($event, $data, $options);

        if (isset($data['sample_size'])) {
            if ($data['sample_size'] > 0) {
                $errorPercentage = 0;
            } else {
                $errorPercentage = 100;
            }
        }

        if (isset($data['match_percentage'], $data['error_percentage'])) {
            $data['true_match_percentage'] = max($data['match_percentage'] - $data['error_percentage'], 0);
        }
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

            if ($entity->sample_size > 0) {
                $errorPercentage = 0;
            } else {
                $errorPercentage = 100;
            }
            $expression = new QueryExpression('GREATEST(match_percentage, 0)');
            $commonData = [
                'true_match_percentage' => $expression,
                'error_percentage' => $errorPercentage,
                'sample_size' => $entity->sample_size,
            ];

            $this->updateAll($commonData, $conditions);
        };

        $updateTotalForAllCategories = function () use ($entity) {
            $query = $this->find();
            $matchPercentage = $query
                ->select(['match_percentage' => $query->func()->avg('match_percentage')])->where([
                    'citizen_id' => $entity->citizen_id,
                    'politician_id' => $entity->politician_id,
                    'category_id IS NOT' => null,
                ])
                ->extract('match_percentage')->first();

            $data = [
                'citizen_id' => $entity->citizen_id,
                'politician_id' => $entity->politician_id,
                'category_id' => null,
                'sample_size' => $entity->sample_size,
                'match_percentage' => $matchPercentage,
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
