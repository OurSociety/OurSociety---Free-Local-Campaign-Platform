<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use Cake\I18n\FrozenTime;
use Cake\View\Helper as Cake;

/**
 * TimeHelper.
 */
class TimeHelper extends Cake\TimeHelper
{
    public function dateCountdown($dateTime, array $options = null)
    {
        $now = FrozenTime::now();

        if ($now->gt($dateTime)) {
            return 'over';
        }

        $options = $options ?? [];
        $options += [
            'end' => $now->addYear(),
            'accuracy' => $now->diffInDays($dateTime) < 7 ? 'day' : 'week',
        ];

        $timeAgoInWords = parent::timeAgoInWords($dateTime, $options);

        if ($timeAgoInWords === 'just now') {
            $timeAgoInWords = 'today';
        } elseif (ctype_digit($timeAgoInWords[0])) {
            $timeAgoInWords = 'in ' . $timeAgoInWords;
        }

        return $timeAgoInWords;
    }
}
