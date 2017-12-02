<?php
declare(strict_types=1);

namespace OurSociety\Action\Municipalities;

use Cake\Http\Response;
use OurSociety\Model\ElectoralDistricts;

class ViewAction extends \OurSociety\Action\ViewAction
{
    /**
     * @route GET /
     * @routeName root
     */
    public function __invoke(...$params): ?Response
    {
        $this->showSignUpOnRootExample();

        return parent::__invoke(...$params);
    }

    protected function getDefaultModelName(): string
    {
        return ElectoralDistricts::class;
    }

    protected function getRecordViewVariable(): string
    {
        return 'municipality';
    }

    protected function showSignUpOnRootExample(): void
    {
        if ($this->isRoute('root')) {
            $this->setViewVariable('showSignUp', true);
        }
    }
}
