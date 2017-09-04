<?php
declare(strict_types=1);

namespace OurSociety\View\Widget;

use Cake\View\Widget as Cake;
//use CrudView\View\Widget as CrudView;

/**
 * DateTimeWidget.
 *
 * TODO: Switch to extend CrudView but implement better JS date/time widget with following requirements:
 *
 * - Supports "date" also (not just "datetime"
 * - Easy to select DOB (a date many years in the past)
 * - Day field can be optional (for positions/qualifications/awards the day isn't important)
 */
class DateTimeWidget extends Cake\DateTimeWidget
//class DateTimeWidget extends CrudView\DateTimeWidget
{

    protected function _daySelect($options, $context): string
    {
        $options += ['placeholder' => 'Day'];

        return parent::_daySelect($options, $context);
    }

    protected function _monthSelect($options, $context): string
    {
        $options += ['placeholder' => 'Month'];

        return parent::_monthSelect($options, $context);
    }

    protected function _yearSelect($options, $context): string
    {
        $options += ['placeholder' => 'Year'];

        return parent::_yearSelect($options, $context);
    }
}
