<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\View\CellTrait;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Entity\Article;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\ArticlesTable;
use OurSociety\Model\Table\UsersTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Articles Controller
 *
 * @method User[] paginate($object = null, array $settings = [])
 */
class ArticlesController extends CrudController
{
    use CellTrait;

    /**
     * @var UsersTable
     */
    public $Users;

    public function index(string $politician): ?Response
    {
        $this->Crud->action()->setConfig([
            'primaryKey' => 'slug',
            'findMethod' => 'forCitizen',
            'scaffold' => [
                'actions' => [
                // TODO: They can click the `name` but would be nice if this "View" button worked.
                //       ... or just switch the template to a non-table one
                //    'view' => ['title' => 'What', 'url' => [
                //        '_name' => 'politician:article',
                //        'article' => 'the-long-road-ahead',
                //        'politician' => 'augustus-octavius-bacon',
                //        'id' => ':primaryKey:',
                //    ]],
                ],
                'breadcrumbs' => [
                    new BreadCrumb('Home'),
                ],
                'fields' => [
                    'name' => [
                        'title' => 'Article Title',
                        'formatter' => function ($name, $value, Article $article) {
                            return $this->createView()->Html->link($value, [
                                '_name' => 'politician:article',
                                'politician' => $article->politician->slug,
                                'article' => $article->slug,
                            ]);
                        }
                    ],
                    'body' => [
                        'title' => 'Article Summary',
                        'formatter' => function ($name, $value, $entity) {
                            return $this->createView()->Text->truncate($value, 100, ['html' => true]);
                        }
                    ],
                    'published' => ['title' => 'Publication Date'],
                    //'politician_id' => ['title' => 'Politician / Author'], // TODO: Only if $politician === null
                ],
            ],
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) use ($politician) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query->matching('Politicians', function (Query $query) use ($politician) {
                return $query->where(['Politicians.slug' => $politician]);
            });
        });

        return $this->Crud->execute();
    }

    public function view(string $politicianSlug, string $articleSlug): ?Response
    {
        $this->viewBuilder()->setLayout('site');

        /** @var UsersTable $users */
        $users = $this->loadModel('Users');
        /** @var ArticlesTable $articles */
        $articles = $this->loadModel('Articles');

        $politician = $users->getBySlug($politicianSlug, $this->Auth->user()->role);
        $article = $articles->getBySlug($articleSlug, $this->Auth->user()->role);

        if ($article->approved === null || $article->published === null) {
            return $this->redirect([
                '_name' => 'politician:profile:article',
                'article' => $article->slug,
            ]);
        }

        $this->set([
            'politician' => $politician,
            'article' => $article,
        ]);

        return null;
    }

    public function add($municipalitySlug): ?Response
    {
        $this->viewBuilder()->setLayout('site');

        $getMunicipalityId = function () use ($municipalitySlug): string {
            /** @var ArticlesTable $table */
            $table = $this->loadModel();
            /** @var ElectoralDistrict $municipality */
            $municipality = $table->ElectoralDistricts->find('slugged', ['slug' => $municipalitySlug])->firstOrFail();

            return $municipality->id;
        };

        $this->Crud->on('beforeSave', function (Event $event) use ($getMunicipalityId) {
            /** @var Article $article */
            $article = $event->getSubject()->entity;
            /** @var User $user */
            $user = $this->Auth->user();

            $article->politician_id = $user->id;
            $article->electoral_district_id = $getMunicipalityId();
        });

        $this->Crud->on('beforeRedirect', function (Event $event) use ($municipalitySlug) {
            if ($event->getSubject()->success !== true) {
                return null;
            }

            return $this->redirect(['_name' => 'municipality', 'municipality' => $municipalitySlug]);
        });

        return $this->_form();
    }

    private function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'page_title' => 'Submit Your Own Idea',
                'fields' => [
                    'id' => ['type' => 'hidden'],
                    'politician_id' => ['type' => 'hidden'],
                    'name' => ['label' => false, 'placeholder' => 'Article Title'],
                    'article_type' => ['label' => false, 'placeholder' => 'Article Type'],
                    'aspect' => ['label' => false, 'placeholder' => 'Article Aspect'],
                    'body' => ['type' => 'editor', 'label' => false],
                    'version' => ['type' => 'hidden'],
                ],
                'form_submit_button_text' => 'Submit Article for Fact-Checking',
                'form_submit_extra_buttons' => false,
            ],
            'messages' => [
                'success' => [
                    'text' => 'Thanks for submitting! This article is now in the queue for fact-­checking and will be approved soon.'
                ],
                'error' => [
                    'text' => 'Could not submit article. Please check for errors below, or contact us if the problem persists.'
                ]
            ],
        ]);

        return $this->Crud->execute();
    }
}
