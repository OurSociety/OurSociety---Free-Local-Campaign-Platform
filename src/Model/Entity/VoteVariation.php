<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * VoteVariation Entity
 *
 * @property string $id
 * @property string $name
 *     http://vip-specification.readthedocs.io/en/release/built_rst/xml/enumerations/vote_variation.html#multi-xml-vote-variation
 * @property bool $vip_spec True if VoteVariation name/tag is from VIP Specification.
 * @property string $description
 *
 * @property Contest[] $contests
 */
class VoteVariation extends AppEntity
{
}
