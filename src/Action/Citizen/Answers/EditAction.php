<?php
declare(strict_types=1);

namespace OurSociety\Action\Citizen\Answers;

use OurSociety\Action;

class EditAction extends Action\EditAction
{
    protected function getViewTemplate(): string
    {
        return 'form';
    }

    protected function getRedirectUrl(): array
    {
        return ['_name' => 'citizen:answers'];
    }

    protected function getSuccessMessage(): string
    {
        return __('Your answer has been revised.');
    }
}
