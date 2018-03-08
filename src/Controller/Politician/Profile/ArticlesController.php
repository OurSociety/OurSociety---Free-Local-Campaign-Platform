<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician\Profile;

use Cake\Event\Event;
use Cake\ORM\Query;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\Article;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Articles Controller
 *
 * @method Article[] paginate($object = null, array $settings = [])
 */
class ArticlesController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'actions_blacklist' => ['export'],
                'fields' => [
                    'name',
                    'published',
                    'approved',
                ],
            ],
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) {
            $event->getSubject()->query = $event->getSubject()->query->matching('Politicians', function (Query $query) {
                return $query->where([
                    'Politicians.slug' => $this->getIdentity()->slug,
                ]);
            });
        });

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->on('afterFind', function (Event $event) {
            /** @var Article $article */
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
            /** @var Article $article */
            $article = $event->getSubject()->entity;
            $user = $this->getIdentity();
            $article->electoral_district_id = $user->electoral_district->id;

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
                'actions_blacklist' => ['export'],
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
            ],
        ]);

        return $this->Crud->execute();
    }
}
