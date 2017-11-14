<?php
declare(strict_types=1);

namespace OurSociety\Action\Users;

use Cake\Http\Response;
use OurSociety\Action\Action;
use OurSociety\Model\Users;

class TutorialAction extends Action
{
    public const MESSAGE_SUCCESS = 'Your location has been stored.';

    /**
     * @route GET /sign-in
     * @routeName users:login
     */
    public function __invoke(...$params): ?Response
    {
        if ($this->hasIdentity() === false) {
            return $this->unauthorizedRedirect();
        }

        if ($this->isLocationFormSubmitted()) {
            $this->persistUserLocation();
            $this->setSuccessMessage(__(self::MESSAGE_SUCCESS));

            return $this->redirect(['_name' => 'citizen:dashboard']);
        }

        $this->setUserToView();
        $this->setBootstrapContainerToFluid();

        return null;
    }

    private function setUserToView(): void
    {
        $this->setViewVariable('user', $this->getIdentity());
    }

    private function persistUserLocation(): void
    {
        $locationId = $this->getRequestData('electoral_district_id');

        /** @var Users $model */
        $model = $this->getModel();
        $model->setLocation($this->getIdentity(), $locationId);

        $this->refreshIdentity();
    }

    private function isLocationFormSubmitted(): bool
    {
        return $this->isFormSubmission();
    }
}
