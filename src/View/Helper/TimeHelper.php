<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\View\Helper as Cake;
use IntlDateFormatter;

/**
 * TimeHelper.
 */
class TimeHelper extends Cake\TimeHelper
{
    private static $niceLongFormat = [IntlDateFormatter::LONG, IntlDateFormatter::SHORT];

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

    /**
     * Format nicely in long format => "Monday, August 28 @ 7.30pm".
     *
     * @param int|string|\DateTime|null $dateString UNIX timestamp, strtotime() valid string or DateTime object
     * @param string|\DateTimeZone|null $timezone User's timezone string or DateTimeZone object
     * @param string|null $locale Locale string.
     * @return string Formatted date string
     */
    public function niceLong($dateString = null, $timezone = null, ?string $locale = null): string
    {
        $timezone = $this->_getTimezone($timezone);
        $formattedDateTimeString = (new Time($dateString))->i18nFormat(self::$niceLongFormat, $timezone, $locale);

        return str_replace(' at ', ' @ ', $formattedDateTimeString);
    }
}
