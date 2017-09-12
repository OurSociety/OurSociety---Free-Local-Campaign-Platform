<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\ORM\TableRegistry;

/**
 * OfficeType Entity
 *
 * @property string $id
 * @property string $name
 */
class OfficeType extends AppEntity
{
    public static function random(): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return TableRegistry::get('OfficeTypes')->find()->order('RAND()')->firstOrFail();
    }
}
