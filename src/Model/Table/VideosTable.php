<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Video;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Videos table.
 *
 * @property UsersTable|Association\BelongsTo $Politicians
 *
 * @method Video get($primaryKey, $options = [])
 * @method Video newEntity($data = null, array $options = [])
 * @method Video[] newEntities(array $data, array $options = [])
 * @method Video|bool save(Entity $entity, $options = [])
 * @method Video patchEntity(Entity $entity, array $data, array $options = [])
 * @method Video[] patchEntities($entities, array $data, array $options = [])
 * @method Video findOrCreate($search, callable $callback = null, $options = [])
 */
class VideosTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Politicians', ['className' => UsersTable::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // url
            ->notEmpty('youtube_video_id')
            ->requirePresence('youtube_video_id', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['politician_id'], 'Politicians'));
    }
}
