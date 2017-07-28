<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Controller\Action;

use Cake\ORM\Query;
use Cake\ORM\Table;
use OurSociety\Controller\Citizen\QuestionsController;
use Cake\Controller\Controller;
use OurSociety\Controller\Action\AnswerAction;
use OurSociety\Controller\Component\AuthComponent;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Entity\User;
use OurSociety\TestSuite\TestCase;

class AnswerActionTest extends TestCase
{
    public function testGet(): void
    {
        $expected = array_fill(0, 10, $this->createMock(Question::class));

        $user = $this->createMock(User::class);

        $authComponent = $this->createMock(AuthComponent::class);
        $authComponent->expects(self::atLeastOnce())->method('user')->willReturn($user);

        $query = $this->createMock(Query::class);
        $query->expects(self::atLeastOnce())->method('toArray')->with()->willReturn($expected);

        $table = $this->createMock(Table::class);
        $table->expects(self::atLeastOnce())->method('find')->willReturn($query);

        /** @var Controller|\PHPUnit_Framework_MockObject_MockObject $controller */
        $controller = $this->createMock(Controller::class);
        $controller->expects(self::atLeastOnce())->method('__get')->with('Auth')->willReturn($authComponent);
        $controller->expects(self::atLeastOnce())->method('loadModel')->with(null)->will(self::returnValue($table));
        $controller->expects(self::atLeastOnce())->method('paginate')->with($query)->will(self::returnValue($query));
        $controller->expects(self::atLeastOnce())->method('set')->with(['questions' => $expected]);

        $action = new AnswerAction($controller, ['redirectUrl' => '/']);
        $action->_get();
    }

    public function testPut(): void
    {

    }
}
