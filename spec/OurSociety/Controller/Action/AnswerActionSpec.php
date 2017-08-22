<?php
declare(strict_types=1);

namespace spec\OurSociety\Controller\Action;

use Cake\Controller\Controller;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\Table;
use OurSociety\Controller\Action\AnswerAction;
use OurSociety\Controller\Component\AuthComponent;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Entity\User;
use PhpSpec\ObjectBehavior;

class AnswerActionSpec extends ObjectBehavior
{
    public function it_is_initializable(Controller $controller): void
    {
        $this->beConstructedWith($controller);
        $this->shouldHaveType(AnswerAction::class);
    }

    public function it_expects_a_redirect_url(
        Controller $controller,
        EventManager $eventManager,
        Request $request
    ): void {
        $request->method()->willReturn('get');
        $request->referer()->willReturn('/referrer');

        $controller->eventManager()->willReturn($eventManager);
        $controller->request = $request;

        $this->beConstructedWith($controller, ['enabled' => true]);
        $this->shouldThrow(\InvalidArgumentException::class)->during('handle');
    }

    public function it_can_handle_a_get_request(
        Request $request,
        Controller $controller,
        EventManager $eventManager,
        AuthComponent $authComponent,
        User $user,
        Table $table,
        Query $query
    ): void {
        $modelType = 'Table';
        $questions = [new Question];

        $request->method()->willReturn('get');
        $request->referer()->willReturn('/referrer');

        $query->count()->willReturn(1);
        $query->toArray()->willReturn($questions);

        $authComponent->user()->willReturn($user);

        $table->find('batch', ['user' => $user])->willReturn($query);

        $controller->request = $request;
        $controller->Auth = $authComponent;
        $controller->eventManager()->willReturn($eventManager);
        $controller->loadModel(null, $modelType)->willReturn($table);
        $controller->paginate($query)->willReturn($query);
        $controller->set(['questions' => $questions])->shouldBeCalled();

        $this->beConstructedWith($controller, ['enabled' => true, 'redirectUrl' => '/anywhere', 'modelFactory' => $modelType]);
        $this->handle();
    }

    public function it_redirects_if_no_questions_left(
        Controller $controller,
        Request $request,
        EventManager $eventManager,
        AuthComponent $authComponent,
        User $user,
        Table $table,
        Query $query
    ): void {
        $modelType = 'Table';

        $authComponent->user()->willReturn($user);

        $table->find('batch', ['user' => $user])->willReturn($query);

        $query->count()->willReturn(0);

        $request->method()->willReturn('get');
        $request->referer()->willReturn('/referrer');

        $controller->Auth = $authComponent;
        $controller->request = $request;
        $controller->eventManager()->willReturn($eventManager);
        $controller->loadModel(null, $modelType)->willReturn($table);
        $controller->paginate($query)->willReturn($query);
        $controller->redirect('/referrer')->shouldBeCalled();

        $this->beConstructedWith($controller, ['enabled' => true, 'redirectUrl' => '/anywhere', 'modelFactory' => $modelType]);
        $this->handle();
    }
}
