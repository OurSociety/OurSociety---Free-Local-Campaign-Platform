<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Text;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\PoliticianVideo;
use OurSociety\Model\Entity\PoliticianArticle;
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
        $this->Crud->on('afterFind', function (Event $event) {
            /** @var PoliticianVideo $video */
            $video = $event->getSubject()->entity;

            return $event->getSubject()->success === true
                ? $this->redirect($video->youtube_video_url)
                : null;
        });

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
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
                    'name' => ['label' => 'Title'],
                    'body' => ['label' => 'Body', 'type' => 'editor'],
                    'published' => [
                        'type' => 'checkbox',
                        'help' => 'After publishing, it may take up to a day for your article to appear due to moderation.',
                    ],
                ],
            ]
        ]);

        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianArticle $article */
            $article = $event->getSubject()->entity;
            $article->id = Text::uuid(); // TODO: Find out why validation fails without this.
            $article->version = $article->version ?: 1; // TODO: Should take default from database?
            $article->politician_id = $this->Auth->user('id');
            $article->published = (bool)$this->request->getData('published') ? Time::now() : null;
        });

        return $this->Crud->execute();
    }
}
