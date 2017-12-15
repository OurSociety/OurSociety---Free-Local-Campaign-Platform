<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\I18n\Date;
use Cake\I18n\Time;

/**
 * Award entity.
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
class Award extends AppEntity
{
    use Traits\ProfileDateAwareTrait;

    public function getIcon(): string
    {
        return 'trophy';
    }

    public function printObtained(): string
    {
        return $this->obtained ? $this->obtained->toFormattedDateString() : 'N/A';
    }
}
