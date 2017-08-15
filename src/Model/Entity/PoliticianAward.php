<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * PoliticianAward Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $name
 * @property string $description
 *
 * @property \OurSociety\Model\Entity\Politician $politician
 */
class PoliticianAward extends AppEntity
{
}
