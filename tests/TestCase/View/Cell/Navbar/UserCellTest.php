<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\View\Cell;

use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use OurSociety\Model\Table\UsersTable;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\TestCase;
use OurSociety\Model\Entity\User;
use OurSociety\View\Cell\Navbar\UserCell;
use Cake\Network\Request;
use Cake\Network\Response;

/**
 * OurSociety\View\Cell\Navbar\UserCell Test Case
 */
class UserCellTest extends TestCase
{
    /**
     * Test display method
     *
     * @dataProvider provideDisplay
     * @param string $expected The expected case.
     * @param array $sessionData The session data.
     * @return void
     */
    public function testDisplay(string $expected, array $sessionData): void
    {
        $session = new Session();
        $session->write($sessionData);

        $request = $this->createMock(Request::class);
        $request->expects(self::any())->method('session')->willReturn($session);
        $request->expects(self::any())->method('getParam')->willReturn([]);

        $response = $this->createMock(Response::class);

        $cell = new UserCell($request, $response);
        $cell->action = 'display';

        $html = $cell->render('display');

        $this->assertContains('Signed in as', $html);
        switch ($expected) {
            case 'non-admin':
                $this->assertContains('<a href="/profile"', $html);
                $this->assertNotContains('<form', $html);
                break;
            case 'admin':
                $this->assertContains('<a href="/profile"', $html);
                $this->assertContains('<form', $html);
                $this->assertContains('onchange="this.form.submit()"', $html);
                $this->assertContains('<select', $html);
                break;
        }

        //self::assertEquals($expected, $actual);
    }

    public function provideDisplay(): array
    {
        /** @var UsersTable $users */
        $users = TableRegistry::get('Users');
        $politician = $users->get(UsersFixture::ID_POLITICIAN);
        $admin = $users->find()->where(['email' => UsersFixture::EMAIL_ADMIN])->firstOrFail();

        return [
            'politician' => [
                'expected' => 'non-admin',
                'sessionData' => ['Auth' => ['User' => $politician, 'Admin' => null]],
            ],
            'admin' => [
                'expected' => 'admin',
                'sessionData' => ['Auth' => ['User' => $admin, 'Admin' => null]],
            ],
            'admin as politician' => [
                'expected' => 'admin',
                'sessionData' => ['Auth' => ['User' => $politician, 'Admin' => $admin]],
            ],
        ];
    }
}
