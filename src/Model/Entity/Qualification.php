<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * Qualification Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $name
 * @property string $institution
 * @property \Cake\I18n\FrozenTime $started
 * @property \Cake\I18n\FrozenTime $ended
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $politician
 */
class Qualification extends AppEntity
{
    use Traits\ProfileDateAwareTrait;

    public function getIcon(): string
    {
        return 'certificate';
    }
}
