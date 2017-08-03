<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Categories\Getter;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;

/**
 * Trait MatchPercentages
 *
 * @method Query find($type = 'all', array $options = [])
 */
trait MatchPercentages
{
    public function getMatchPercentages(User $citizen, User $politician, bool $inverse = false, ?int $limit = null): CollectionInterface
    {
        $this->hasOne('ValueMatch', [
            'className' => ValueMatchesTable::class,
            'conditions' => [
                'ValueMatch.citizen_id' => $citizen->id,
                'ValueMatch.politician_id' => $politician->id,
                'ValueMatch.category_id IS NOT' => null,
            ],
        ]);

        return $this->find()->contain(['ValueMatch'])->order([
            'ValueMatch.true_match_percentage' => $inverse === false ? 'DESC' : 'ASC',
        ])->limit($limit)->all();
    }
}
