<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\View\CellTrait;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\PoliticianArticle;
use OurSociety\Model\Entity\User;
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
                //        '_name' => 'citizen:politician:article',
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
                                '_name' => 'citizen:politician:article',
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

    public function view(string $politician, string $article): ?Response
    {
        $this->set([
            'politician' => $this->loadModel('Users')->find('politicianForCitizen')->where([
                'slug' => $politician,
            ])->firstOrFail(),
            'article' => $this->loadModel('PoliticianArticles')->find('forCitizen')->where([
                'slug' => $article,
            ])->firstOrFail(),
        ]);

        return null;
    }
}
