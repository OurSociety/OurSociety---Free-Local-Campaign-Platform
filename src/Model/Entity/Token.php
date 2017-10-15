<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

/**
 * Token Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $lookup
 * @property string $hash
 * @property \Cake\I18n\FrozenTime $expires
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $user
 *
 * @property string $cookie_value
 */
class Token extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'lookup' => true,
        'hash' => true,
        'expires' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];

    protected function _getCookieValue(): string
    {
        $lookup = $this->_properties['lookup'] ?? null;
        $hash = $this->_properties['hash'] ?? null;

        if ($lookup === null || $hash === null) {
            throw new \RuntimeException('Can not generate cookie value from incomplete token');
        }

        return sprintf('%s:%s', $lookup, $hash);
    }
}
