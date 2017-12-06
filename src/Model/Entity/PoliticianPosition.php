<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * PoliticianPosition Entity
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
class PoliticianPosition extends AppEntity
{
    public function getIcon(): string
    {
        return 'suitcase';
    }

    protected function _setStarted($value)
    {
        $this->setYearMonth($value);
    }

    protected function _setEnded($value)
    {
        $this->setYearMonth($value);
    }
}
