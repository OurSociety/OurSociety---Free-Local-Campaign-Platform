<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use OurSociety\View\AppView;

/**
 * Notification Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $body
 * @property \Cake\I18n\FrozenTime $seen
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $user
 */
class Notification extends AppEntity
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
        'title' => true,
        'body' => true,
        'read' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];

    public function getIcon(): string
    {
        return 'bell-o';
    }

    public function isMarkedAsRead(): bool
    {
        $seen = $this->_properties['seen'] ?? null;

        return $seen !== null;
    }

    public function renderLink(AppView $view, array $options = null): string
    {
        return $view->Html->link($this->title, [
            '_name' => 'citizen:notification',
            'notification' => $this->id,
        ], $options);
    }
}
