<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

use Cake\Datasource\EntityInterface as Entity;
use Cake\I18n\FrozenTime;
use Cake\ORM\Association;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator as CakeValidator;
use OurSociety\Model\Entity\Token;
use OurSociety\Model\Entity\User;
use OurSociety\ORM\TableRegistry;
use OurSociety\Validation\Validator as AppValidator;

/**
 * Tokens Model
 *
 * @property UsersTable|Association\BelongsTo $Users
 *
 * @method Token get($primaryKey, $options = [])
 * @method Token newEntity($data = null, array $options = [])
 * @method Token[] newEntities(array $data, array $options = [])
 * @method Token|bool save(Entity $entity, $options = [])
 * @method Token patchEntity(Entity $entity, array $data, array $options = [])
 * @method Token[] patchEntities($entities, array $data, array $options = [])
 * @method Token findOrCreate($search, callable $callback = null, $options = [])
 */
class TokensTable extends AppTable
{
    public static function instance(array $options = null): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return TableRegistry::get('Tokens', $options ?? []);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Users');
    }

    /**
     * {@inheritdoc}
     */
    public function validationDefault(CakeValidator $validator): AppValidator
    {
        return parent::validationDefault($validator)
            // lookup
            ->notEmpty('lookup')
            ->requirePresence('lookup', 'create')
            ->scalar('lookup')
            // hash
            ->notEmpty('hash')
            ->requirePresence('hash', 'create')
            ->scalar('hash')
            // expires
            ->dateTime('expires')
            ->notEmpty('expires')
            ->requirePresence('expires', 'create');
    }

    /**
     * {@inheritdoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return parent::buildRules($rules)
            ->add($rules->existsIn(['user_id'], 'Users'));
    }

    public function createToken(User $user): Token
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->saveOrFail($this->newEntity([
            'user_id' => $user->id,
            'lookup' => $this->generateToken(12),
            'hash' => $this->generateToken(64),
            'expires' => FrozenTime::now()->addYear(),
        ]));
    }

    public function generateToken(int $length): string
    {
        return bin2hex(random_bytes($length));
    }
}
