<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\View\Helper;

use Cake\Network\Request;
use Cake\View\View;
use OurSociety\Model\Entity\User;
use OurSociety\TestSuite\TestCase;
use OurSociety\View\AppView;
use OurSociety\View\Helper\HtmlHelper;

class HtmlHelperTest extends TestCase
{
    /**
     * @dataProvider provideDashboardLink
     * @param string|false $routePrefix The route routePrefix of request.
     * @param string|null $role The specified role, if any.
     * @param string|null $title The specified title, if any.
     * @param string $expectedUrl The expected link URL.
     * @param string $expectedText The expected link text.
     */
    public function testDashboardLink($routePrefix, string $role = null, string $title = null, string $expectedUrl, string $expectedText): void
    {
        /** @var View $view */
        $view = new AppView();
        $helper = new HtmlHelper($view);
        $helper->request = $this->createMock(Request::class);
        $helper->request->expects(self::any())->method('getParam')->with('prefix')->willReturn($routePrefix);

        $this->assertHtml(['a' => ['href' => $expectedUrl], $expectedText, '/a'], $helper->dashboardLink($role, $title));
    }

    public function provideDashboardLink(): array
    {
        $data = [];
        $prefixToExpectedUrl = [
            false => ['url' => '/home', 'text' => 'Home'],
            'politician' => ['url' => '/politician', 'text' => 'Politician Dashboard'],
            'politician/profile' => ['url' => '/politician', 'text' => 'Politician Dashboard'],
            'admin' => ['url' => '/admin', 'text' => 'Admin Dashboard'],
        ];
        $roleToExpectedUrl = [
            null => ['url' => null, 'text' => null],
            User::ROLE_CITIZEN => ['url' => '/citizen', 'text' => 'Citizen Dashboard'],
            User::ROLE_POLITICIAN => ['url' => '/politician', 'text' => 'Politician Dashboard'],
            User::ROLE_ADMIN => ['url' => '/admin', 'text' => 'Admin Dashboard'],
        ];
        foreach ($prefixToExpectedUrl as $prefix => $expected) {
            foreach ($roleToExpectedUrl as $role => $expectedOverride) {
                foreach ([null, 'Custom Title'] as $title) {
                    $name = sprintf(
                        'success (%s prefix + %s role + %s title)',
                        empty($prefix) ? 'no' : $prefix,
                        empty($role) ? 'no' : $role,
                        empty($title) ? 'no' : 'custom'
                    );
                    $data[$name] = [
                        'routePrefix' => empty($prefix) ? false : $prefix,
                        'role' => empty($role) ? null : $role,
                        'title' => $title,
                        'expectedUrl' => $expectedOverride['url'] ?? $expected['url'],
                        'expectedText' => $title ?? $expectedOverride['text'] ?? $expected['text'],
                    ];
                }
            }
        }
        return $data;
    }
}
