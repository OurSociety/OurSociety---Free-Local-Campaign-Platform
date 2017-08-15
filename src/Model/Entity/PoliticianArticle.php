<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * PoliticianArticle Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $slug
 * @property string $name
 * @property string $body
 * @property int $version
 * @property \Cake\I18n\FrozenTime $approved
 * @property \Cake\I18n\FrozenTime $published
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $politician
 */
class PoliticianArticle extends AppEntity
{
}
