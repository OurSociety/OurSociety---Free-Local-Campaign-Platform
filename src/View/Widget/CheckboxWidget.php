<?php
declare(strict_types=1);

namespace OurSociety\View\Widget;

use BootstrapUI\View\Widget as BootstrapUI;
use Cake\Chronos\ChronosInterface;
use Cake\View\Widget\WidgetInterface as Widget;

class CheckboxWidget extends BootstrapUI\CheckboxWidget implements Widget
{
    /**
     * {@inheritdoc}.
     *
     * It is often preferable to store "boolean" values in nullable datetime columns. We cast those to real booleans
     * here so that checkbox state is correctly rendered (null = false, not null = true).
     */
    protected function _isChecked($data)
    {
        if ($data['val'] instanceof ChronosInterface) {
            $data['val'] = (bool)$data['val'];
        }

        return parent::_isChecked($data);
    }
}
