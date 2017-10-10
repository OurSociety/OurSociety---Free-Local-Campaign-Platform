<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Crud\Listener\ApiListener;
use OurSociety\Model\Table\ElectoralDistrictsTable;
use Psr\Http\Message\ResponseInterface as Response;
use RuntimeException;

/**
 * Municipalities Controller
 *
 * @property ElectoralDistrictsTable $Municipalities
 */
class MunicipalitiesController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'ElectoralDistricts';

        $allowedActions = ['articles'];
        if ($this->request->getParam('action') === 'view' && $this->request->getParam('municipality') !== false) {
            $allowedActions[] = 'view';
        }

        $this->Auth->allow($allowedActions);
    }

    /**
     * @route GET /municipalities/lookup
     * @routeName municipality:lookup
     */
    public function lookup(): ?Response
    {
        $this->Crud->addListener('api', ApiListener::class);

        $this->Crud->on('beforeLookup', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query
                ->where([
                    array_values($query->aliasField('name'))[0] . ' LIKE' => '%' . $this->request->getQuery('name') . '%',
                ])
                ->matching('DistrictTypes', function (Query $query) {
                    return $query->where(['id_vip' => 'municipality']);
                })
                ->contain(['Parents']);
        });

        return $this->Crud->execute();
    }

    public function view(?string $municipalitySlug = null): ?Response
    {
        if ($municipalitySlug === null) {
            return $this->redirectToUserMunicipality();
        }

        $this->Crud->action()->setConfig('findMethod', 'forMunicipalityProfile');

        return $this->Crud->execute();
    }

    public function articles(string $slug): ?Response
    {
        /** @var ElectoralDistrictsTable $table */
        $table = $this->loadModel();

        $this->set([
            'municipality' => $table->getBySlug($slug),
            'articles' => $table->getArticlesBySlug($slug),
        ]);

        return null;
    }

    public function edit(string $municipalitySlug): ?Response
    {
        $this->Crud->action()->setConfig([
            'relatedModels' => false,
            'scaffold' => [
                'actions' => [],
                'form_submit_button_text' => 'Update Town Information',
                'form_submit_extra_buttons' => false,
                'fields' => [
                    'description' => ['placeholder' => 'Town Information', 'label' => false]
                ],
            ],
        ]);

        $this->Crud->on('beforeRedirect', function (Event $event) use ($municipalitySlug) {
            if ($event->getSubject()->success !== true) {
                return null;
            }

            return $this->redirect(['_name' => 'municipality', 'municipality' => $municipalitySlug]);
        });

        return $this->Crud->execute();
    }

    private function redirectToUserMunicipality(): Response
    {
        $user = $this->getCurrentUser();

        if ($user === null) {
            throw new RuntimeException('Guests should not be able to access this method.');
        }

        return $this->redirect($user->getMunicipalityRoute());
    }
}
