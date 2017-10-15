<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Http\Response;
use Cake\Network\Session;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use OurSociety\Controller\AppController;
use OurSociety\Controller\Component\AuthComponent;
use OurSociety\Middleware\AuthorizationMiddleware;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Model;

abstract class Action
{
    private $controller;

    public function __construct(AppController $controller)
    {
        $this->controller = $controller;
    }

    abstract public function __invoke(...$params): ?Response;

    protected function authenticateAs(User $user): void
    {
        $this->controller->authenticateIdentity($user->id);
    }

    protected function deleteSession(string $key): void
    {
        $this->getSession()->delete($key);
    }

    protected function setErrorMessage(string $message): void
    {
        $this->controller->Flash->error($message);
    }

    protected function getRequestData($name = null, $default = null)
    {
        //dd($this->controller->request->getData());

        return $this->controller->request->getData($name, $default);
    }

    protected function getIdentity(): User
    {
        return $this->controller->getIdentity();
    }

    protected function getResponse(): Response
    {
        return $this->controller->response;
    }

    protected function hasIdentity(): bool
    {
        return $this->controller->hasIdentity();
    }

    protected function refreshIdentity(): void
    {
        $this->controller->refreshIdentity();
    }

    protected function setInfoMessage(string $message): void
    {
        $this->controller->Flash->info($message);
    }

    protected function setWarningMessage(string $message): void
    {
        $this->controller->Flash->warning($message);
    }

    protected function redirect(array $url): ?Response
    {
        return $this->controller->redirect($url);
    }

    protected function setSuccessMessage(string $message): void
    {
        $this->controller->Flash->success($message);
    }

    protected function isFormSubmission(): bool
    {
        return $this->isPostRequest() || $this->isPutRequest();
    }

    protected function isPostRequest(): bool
    {
        return $this->controller->request->is('post') === true;
    }

    protected function isPutRequest(): bool
    {
        return $this->controller->request->is('put') === true;
    }

    protected function setResponse(Response $response): void
    {
        $this->controller->response = $response;
    }

    protected function readSession($path)
    {
        return $this->getSession()->read($path);
    }

    protected function setViewVariable(string $name, $value = null): void
    {
        $this->controller->set($name, $value);
    }

    protected function setViewVariables(array $variables): void
    {
        $this->controller->set($variables);
    }

    protected function setCookie($cookie): void
    {
        $this->setResponse($this->getResponse()->withCookie($cookie));
    }

    protected function setBootstrapContainerToFluid(): void
    {
        $this->setViewVariable('containerClass', 'container-fluid');
    }

    protected function writeSession(string $name, $value): void
    {
        $this->getSession()->write($name, $value);
    }

    protected function getModel(string $modelName = null): Model
    {
        if ($modelName === null) {
            $namespaceParts = (array)explode('\\', static::class);
            $namespaceIndex = (int)count($namespaceParts) - 2;
            $modelName = $namespaceParts[$namespaceIndex];
        }

        $modelClass = preg_replace('/Model$/', $modelName, Model::class);

        return new $modelClass;
    }

    protected function getResultsPage(Query $paginationQuery): ResultSet
    {
        return $this->controller->paginate($paginationQuery);
    }

    protected function getSingularEntityName(): string
    {
        return $this->getModel()->getEntityName();
    }

    protected function isSubmitRequest(): bool
    {
        return $this->controller->request->is(['patch', 'post', 'put']) === true;
    }

    protected function unauthorizedRedirect(): Response
    {
        $this->setErrorMessage(AuthComponent::ERROR_AUTH_UNAUTHORIZED);

        return $this->redirect(AuthorizationMiddleware::UNAUTHORIZED_REDIRECT_URL);
    }

    private function getSession(): Session
    {
        return $this->controller->request->getSession();
    }
}
