<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\View\CellTrait;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\PoliticianArticlesTable;
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

    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'PoliticianArticles';
    }

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
                        'formatter' => function ($name, $value, PoliticianArticle $article) {
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
        /** @var UsersTable $users */
        $users = $this->loadModel('Users');
        /** @var PoliticianArticlesTable $articles */
        $articles = $this->loadModel('PoliticianArticles');

        $politician = $users->getBySlug($politicianSlug, $this->Auth->user()->role);
        $article = $articles->getBySlug($articleSlug, $this->Auth->user()->role);

        if ($article->approved === null || $article->published === null) {
            return $this->redirect([
                'prefix' => 'politician/profile',
                'controller' => 'Articles',
                'action' => 'view',
                $article->id,
            ]);
        }

        $this->set([
            'politician' => $politician,
            'article' => $article,
        ]);

        return null;
    }
}
