<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * PoliticianQualification Entity
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
 * @property \OurSociety\Model\Entity\Politician $politician
 */
class PoliticianQualification extends AppEntity
{
    public function getIcon(): string
    {
        return 'certificate';
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
