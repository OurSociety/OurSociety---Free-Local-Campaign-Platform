<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use Cake\Event\Event;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Citizen community contributors controller
 */
class CommunityContributorsController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'Users';
    }

    public function view(): ?Response
    {
        $slug = $this->getCurrentUserSlug();
        $this->setRequestPassedParam($slug);

        $this->Crud->action()->setConfig([
            'viewVar' => 'politician',
            'findMethod' => 'communityContributor',
        ]);

        return $this->Crud->execute();
    }

    public function edit(string $slug = null): ?Response
    {
        if ($slug === null) {
            $slug = $this->getCurrentUserSlug();
            $this->setRequestPassedParam($slug);
        }

        //$this->Crud->on('beforeFind', function (Event $event) {
        //    /** @var Query $query */
        //    $query = $event->getSubject()->query;
        //    $query->where(['Users.id' => $this->Auth->user('id')], [], true);
        //});

        $this->Crud->on('afterSave', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->Auth->refreshSession();
            }
        });

        $this->Crud->on('beforeRedirect', function (Event $event) {
            $event->getSubject()->url = ['_name' => 'citizen:profile'];
        });

        return $this->Crud->execute();
    }

    /**
     * Get slug of the currently logged in user.
     *
     * @return string
     */
    private function getCurrentUserSlug(): string
    {
        return $this->getCurrentUser()->slug;
    }

    /**
     * Set the passed param for current request.
     *
     * @param string $first The first passed param.
     * @return void
     */
    private function setRequestPassedParam(string $first): void
    {
        $this->request->addParams(['pass' => [$first]]);
    }
}
