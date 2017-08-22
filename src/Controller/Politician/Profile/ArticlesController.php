<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician\Profile;

use Cake\Event\Event;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Articles Controller
 *
 * @method PoliticianArticle[] paginate($object = null, array $settings = [])
 */
class ArticlesController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'PoliticianArticles';
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name',
                    'published',
                    'approved',
                ],
            ],
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) {
            $event->getSubject()->query = $event->getSubject()->query->where([
                'Politicians.slug' => $this->Auth->user('slug'),
            ]);
        });

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->on('beforeRender', function (Event $event) {
            /** @var PoliticianArticle $article */
            $article = $event->getSubject()->entity;

            if ($article->published === null) {
                $this->Flash->error('This article is currently unpublished. Please publish it so it can be viewed by citizens.');
            }

            if ($article->approved === null) {
                $this->Flash->warning('This article is currently awaiting moderation. Once approved it will be available to citizens.');
            }
        });

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianArticle $article */
            $article = $event->getSubject()->entity;
            /** @var User $user */
            $user = $this->Auth->user();

            if ($user->isPolitician()) {
                $article->politician_id = $user->id;
            }
        });

        return $this->_form();
    }

    public function edit(): ?Response
    {
        return $this->_form();
    }

    private function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'id' => ['type' => 'hidden'],
                    'politician_id' => ['type' => 'hidden'],
                    'name' => ['label' => 'Title'],
                    'body' => ['type' => 'editor'],
                    'version' => ['type' => 'hidden'],
                    'published' => [
                        'type' => 'checkbox',
                        'help' => 'After publishing, it may take up to a day for your article to appear due to moderation.',
                    ],
                ],
            ]
        ]);

        return $this->Crud->execute();
    }
}
