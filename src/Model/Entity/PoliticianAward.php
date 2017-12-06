<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\I18n\Date;
use Cake\I18n\Time;

/**
 * PoliticianAward Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $name
 * @property string $description
 * @property Date $obtained
 * @property Time $created
 * @property Time $modified
 *
 * @property User $politician
 */
class PoliticianAward extends AppEntity
{
    public function getIcon(): string
    {
        return 'trophy';
    }

    protected function _setObtained($value)
    {
        $this->setYearMonth($value);
    }
}
