<?php
declare(strict_types=1);

namespace OurSociety\Database\Type;

use Cake\Database\Type\DateType;
use Cake\I18n\FrozenDate;
use Cake\Log\LogTrait;
use DateTimeInterface;
use InvalidArgumentException;
use Psr\Log\LogLevel;

class MonthType extends DateType
{
    use LogTrait;

    public const TYPE_NAME = 'month';

    public function marshal($value)
    {
        if (is_string($value)) {
            try {
                $value = FrozenDate::createFromFormat('Y-m', $value);
            } catch (InvalidArgumentException $exception) {
                $this->log('Date not in correct format', LogLevel::DEBUG, [
                    'value' => $value,
                    'exception' => $exception,
                ]);
            }
        }

        $date = parent::marshal($value);

        if ($date instanceof DateTimeInterface) {
            $date = $date->setDate($date->format('Y'), $date->format('m'), 1);
        }

        return $date;
    }
}
