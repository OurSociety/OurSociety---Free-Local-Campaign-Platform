<?php
declare(strict_types=1);

namespace OurSociety\Action\People;

use Cake\Http\Response;
use OurSociety\Action\Action;
use OurSociety\Model\Entity\User;

class RedirectAction extends Action
{
    public function __invoke(...$params): ?Response
    {
        $publicProfileRoute = $this->getPublicProfileRoute($params);

        return $this->redirect($publicProfileRoute);
    }

    private function getIdentifier($params): string
    {
        return $params[0];
    }

    private function getPublicProfileRoute($params): array
    {
        return $this->getUser($this->getIdentifier($params))->getPublicProfileRoute();
    }

    private function getUser(string $identifier): User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getModel('Users')->getByUniqueIdentifier($identifier, ['role', 'slug']);
    }
}
