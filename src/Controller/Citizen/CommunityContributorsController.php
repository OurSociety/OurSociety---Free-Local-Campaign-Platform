<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use Cake\Event\Event;
use OurSociety\Controller\CrudController;
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
        $this->setSlugParam();

        $this->Crud->action()->setConfig([
            'viewVar' => 'politician',
            'findMethod' => 'communityContributor',
        ]);

        return $this->Crud->execute();
    }

    public function edit(string $slug = null): ?Response
    {
        if ($slug === null) {
            $this->setSlugParam();
        }

        //$this->Crud->on('beforeFind', function (Event $event) {
        //    /** @var Query $query */
        //    $query = $event->getSubject()->query;
        //    $query->where(['Users.id' => $this->getIdentity()->id], [], true);
        //});

        $this->Crud->on('afterSave', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->refreshIdentity();
            }
        });

        $this->Crud->on('beforeRedirect', function (Event $event) {
            $event->getSubject()->url = ['_name' => 'citizen:profile'];
        });

        return $this->Crud->execute();
    }

    /**
     * Set slug param.
     *
     * Sets the first passed parameter to the slug of the authenticated user.
     *
     * @return void
     */
    private function setSlugParam(): void
    {
        $this->request->addParams(['pass' => [$this->getIdentity()->slug]]);
    }
}
