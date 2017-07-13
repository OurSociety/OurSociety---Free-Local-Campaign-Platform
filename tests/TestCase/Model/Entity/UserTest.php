<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Model\Table;

use Cake\I18n\Time;
use OurSociety\Model\Entity\User;
use OurSociety\TestSuite\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider provideIsTokenExpired
     * @param bool $expected The expected value.
     * @param Time|null $time The time token expires.
     */
    public function testIsTokenExpired(bool $expected, ?Time $time): void
    {
        $user = new User;
        $user->token_expires = $time;
        self::assertEquals($expected, $user->isTokenExpired());
    }

    public function provideIsTokenExpired(): array
    {
        return [
            'not expired' => ['expected' => false, 'time' => Time::now()->addMinute()],
            'expired (now)' => ['expected' => true, 'time' => Time::now()],
            'expired (null)' => ['expected' => true, 'time' => null],
        ];
    }

    public function testWithToken(): void
    {
        $user = new User;
        self::assertNull($user->token);
        self::assertNull($user->token_expires);

        $user = $user->withToken();
        self::assertRegExp(sprintf('/^[A-Z0-9]{%d}$/', User::TOKEN_LENGTH), $user->token);
        self::assertEquals(User::TOKEN_EXPIRY_HOURS, $user->token_expires->diffInHours());
    }
}
