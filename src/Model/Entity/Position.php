<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Position entity.
 *
 * @property string $id
 * @property string $politician_id
 * @property string $name
 * @property string $company
 * @property \Cake\I18n\FrozenTime $started
 * @property \Cake\I18n\FrozenTime $ended
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $politician
 */
class Position extends AppEntity
{
    use Traits\ProfileDateAwareTrait;

    public function getIcon(): string
    {
        return 'suitcase';
    }
}
