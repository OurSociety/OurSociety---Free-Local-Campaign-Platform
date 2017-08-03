<?php
declare(strict_types=1);

namespace OurSociety\Model\Behavior;

use \RuntimeException;

/**
 * Disable behavior exception.
 *
 * Allows a behavior to disable itself as it is being loaded.
 *
 * If thrown from a behavior's constructor, it will be caught and ignored by `AppTable::addBehavior()`.
 *
 * Does not currently handle cases where the behavior is loaded directly on the BehaviorRegistry instance
 * (e.g. not `$this->behaviors()->load()`, only `$this->addBehavior()`).
 */
class DisableBehaviorException extends RuntimeException
{
}
