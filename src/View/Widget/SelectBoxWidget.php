<?php
declare(strict_types=1);

namespace OurSociety\View\Widget;

use BootstrapUI\View\Widget as BootstrapUI;

class SelectBoxWidget extends BootstrapUI\SelectBoxWidget
{
    protected function _renderContent($data): array
    {
        $attrs = ['disabled'];
        if (!isset($data['default'])) {
            $attrs[] = 'selected';
        }

        $placeholder = $this->_templates->format('option', [
            'text' => $data['placeholder'] ?? $data['empty'] ?? '',
            'attrs' => $this->_templates->formatAttributes($attrs),
        ]);

        $options = parent::_renderContent($data);

        array_unshift($options, $placeholder);

        return $options;
    }
}
