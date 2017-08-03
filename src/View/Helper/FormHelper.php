<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use Cake\View\View;
use OurSociety\View\Widget;

/**
 * FormHelper.
 */
class FormHelper extends BootstrapUI\FormHelper
{
    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);

        $this->setConfig('widgets', [
            'answer' => [Widget\AnswerWidget::class],
            'importance' => [Widget\ImportanceWidget::class],
            'editor' => [Widget\EditorWidget::class],
            'zip' => [Widget\ZipWidget::class, 'text'],
            // TODO: Implement better date/time widget with following requirements:
            // - Supports "date" also (not just "datetime"
            // - Easy to select DOB (a date many years in the past)
            // - Day field can be optional (for positions/qualifications/awards the day isn't important)
            //'datetime' => [CrudViewWidget\DateTimeWidget::class, 'select']
        ]);
    }
}
