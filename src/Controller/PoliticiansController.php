<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Cake\View\CellTrait;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\Test\Fixture\UsersFixture;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Politicians Controller
 *
 * @method User[] paginate($object = null, array $settings = [])
 */
class PoliticiansController extends CrudController
{
    use CellTrait;

    /**
     * @var UsersTable
     */
    public $Users;

    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'Users';
        $this->Auth->allow(['index', 'view', 'claim']);
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'findMethod' => 'politicianForCitizen',
            'scaffold' => [
                'fields' => [
                    'name',
                    'picture',
                    'answer_count' => ['title' => '# Answers'],
                    'last_seen',
                ],
                'actions' => [
                    'view',
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(string $slug = null): ?Response
    {
        /** @var User $user */
        $user = $this->Auth->user();
        $slug = $slug ?: $user->slug; // TODO: Slug should not be optional for this public politician view.

        /** @var User $politician */
        $politician = $this->loadModel('Users')
            ->find('politicianForCitizen')
            ->where(compact('slug'))
            ->firstOrFail();

        if ($politician->verified === null) {
            $link = function (string $text, array $url): string {
                /** @noinspection HtmlUnknownTarget,UnknownInspectionInspection */
                return sprintf('<a href="%s">%s</a>', Router::url($url), $text);
            };

            $this->Flash->warning(__(
                'This profile has not been claimed. Click here to see {example_profile} or choose {claim_profile} to create your account.', [
                    'example_profile' => $link(__('an example profile'), [
                        '_name' => 'politician',
                        'politician' => UsersFixture::POLITICIAN_SLUG
                    ]),
                    'claim_profile' => $link(__('Claim Profile'), [
                        '_name' => 'politician:claim',
                        'politician' => $politician->slug
                    ]),
                ]
            ), ['params' => ['escape' => false]]);
        }

        $this->set(compact('politician'));

        return null;
    }

    public function claim(string $slug = null): ?Response
    {
        /** @var UsersTable $users */
        $users = $this->loadModel('Users');
        $politician = $users->getBySlug($slug);

        if ($politician->verified !== null) {
            throw new NotFoundException('This profile has been claimed.');
        }

        if ($this->request->is(['put', 'post'])) {
            if ($this->request->getData('token') !== $politician->token) {
                $politician->setError('token', 'Sorry, the code you have entered does not match our records.');
            } else {
                $formData = [
                    'email' => $this->request->getData('email'),
                    'password' => $this->request->getData('password'),
                    'verified' => Time::now(),
                ];
                $entity = $this->Users->patchEntity($politician, $formData);
                if (empty($entity->getErrors())) {
                    $saved = $this->Users->save($this->Users->patchEntity($politician, $formData));
                    if ($saved) {
                        $this->Auth->refreshSession($politician);
                        $this->Flash->success(__(
                            'You have claimed the profile of {politician_name} and are now logged in. '
                            . 'Please update the remaining sections and see the {getting_started} guide.',
                            [
                                'politician_name' => $politician->name,
                                'getting_started' => sprintf(
                                    '<a href="%s">%s</a>',
                                    '/docs/onboarding',
                                    __('Getting Started')
                                )
                            ]
                        ), ['params' => ['escape' => false]]);
                        return $this->redirect(['_name' => 'politician:profile']);
                    }
                }
            }
        }

        unset($politician->token, $politician->password);

        $this->set(compact('politician'));

        return null;
    }

    public function embed(string $slug = null): ?Response
    {
        // Start same as view()
        /** @var User $user */
        $user = $this->Auth->user();
        $slug = $slug ?: $user->slug; // TODO: Slug should not be optional for this public politician view.

        /** @var User $politician */
        $politician = $this->loadModel('Users')
            ->find('politicianForCitizen')
            ->where(compact('slug'))
            ->firstOrFail();

        if ($politician->verified === null) {
            $link = function (string $text, array $url): string {
                /** @noinspection HtmlUnknownTarget,UnknownInspectionInspection */
                return sprintf('<a href="%s">%s</a>', Router::url($url), $text);
            };

            $this->Flash->warning(__(
                'This profile has not been claimed. Click here to see {example_profile} or choose {claim_profile} to create your account.', [
                    'example_profile' => $link(__('an example profile'), [
                        '_name' => 'politician',
                        'politician' => UsersFixture::POLITICIAN_SLUG
                    ]),
                    'claim_profile' => $link(__('Claim Profile'), [
                        '_name' => 'politician:claim',
                        'politician' => $politician->slug
                    ]),
                ]
            ), ['params' => ['escape' => false]]);
        }

        $this->set(compact('politician'));
        // End same as view()

        $this->viewBuilder()->setLayout('embed');
        $this->render('embed');

        return null;
    }}
