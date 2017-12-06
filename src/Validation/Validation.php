<?php
declare(strict_types=1);

namespace OurSociety\Validation;

use Cake\I18n\FrozenDate;
use Cake\Validation as Cake;

/**
 * Validation Class. Used for validation of model data
 *
 * Offers different validation methods.
 */
class Validation extends Cake\Validation
{
    /**
     * Validates year/month pairs.
     *
     * @param array|mixed $check The value (e.g. `['year' => '2000', 'month' => '01']`).
     * @param array $options The options (e.g. `['past' => true]`).
     * @return bool True on success, false otherwise.
     */
    public static function yearMonth($check, array $options = null): bool
    {
        $options = $options ?? [];
        $options += ['past' => true];

        if (is_string($check)) {
            [$year, $month] = explode('-', $check);
            $check = ['year' => $year, 'month' => $month];
        }

        if (is_array($check)) {
            foreach (['year', 'month'] as $key) {
                if (!is_numeric($check[$key])) {
                    return false;
                }
                $check[$key] = (int)$check[$key];
            }

            try {
                $date = FrozenDate::create((int)$check['year'], (int)$check['month'], 1);
            } catch (\InvalidArgumentException $exception) {
                return false;
            }

            $validTense = true;
            if ($options['past'] === true) {
                $validTense = $date->lt(FrozenDate::now());
            }

            return $validTense;
        }

        return false;
    }
}
