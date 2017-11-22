<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\Datasource\Exception\RecordNotFoundException;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Entity\ValueMatch;

/**
 * ValueMatches.
 */
class ValueMatches extends Model
{
    /**
     * @var self
     */
    private static $instance;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function getPoliticianMatch(User $user): ValueMatch
    {
        try {
            return $this->repository->find()->contain(['Politicians'])->where([
                'citizen_id' => $user->id,
                'category_id IS' => null,
            ])->firstOrFail();
        } catch (RecordNotFoundException $exception) {
            return $this->repository->newEntity();
        }
    }
}
