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

        if ($this->hasRecordIdentifier($params) === false) {
            return $this->redirectToUserMunicipality();
        }

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

    private function showSignUpOnRootExample(): void
    {
        if ($this->isRoute('root') === false) {
            return;
        }

        $this->setViewVariable('showSignUp', true);
    }

    private function redirectToUserMunicipality(): Response
    {
        if ($this->hasIdentity() === false) {
            return $this->unauthorizedRedirect();
        }

        return $this->redirect($this->getIdentity()->getMunicipalityRoute());
    }
}
