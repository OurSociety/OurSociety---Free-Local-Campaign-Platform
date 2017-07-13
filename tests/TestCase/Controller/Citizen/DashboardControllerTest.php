<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class DashboardControllerTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideIndex
     * @param string $expected The expected case.
     * @param string|null $email The email of the user to authenticate as, if any.
     */
    public function testIndex(string $expected, string $email = null): void
    {
        $this->auth($email);
        $this->get(['_name' => 'citizen:dashboard']);

        switch ($expected) {
            case 'success':
                $this->assertResponseOk();
                $this->assertResponseContains('Citizen Dashboard');
                $this->assertResponseContains('Questions');
                $questions = [
                    ['question' => 'Multiculturalism is a crucial part of forming a better country and world.'],
                    ['question' => 'Education is best provided by the free market, achieving greater quality, accountability, and efficiency with a more diversity of choice.'],
                    ['question' => 'The government should increase the minimum wage to ensure a living wage.'],
                    ['question' => 'Corporate media is sensationalized in order to generate more views but does not take into account the harm being done to the populace.'],
                    ['question' => 'The U.S. should increase military spending.'],
                    ['question' => 'Provision of the internet should be socialised and made available free of charge.'],
                    ['question' => 'Strict environmental laws and regulations harm the economy and cost jobs.'],
                    ['question' => 'Inheritance tax should increase significantly after reaching a specific dollar amount.'],
                    ['question' => 'Public education should have a stronger focus on analytics capability rather than fact memorization.'],
                    ['question' => 'We should continue to provide tax incentives for individuals purchasing electric cars.'],
                ];
                // TODO: Fix RAND(seed) in CI, or perhaps it's an issue with Generator::seed().
                //foreach ($questions as $question) {
                //    $this->assertResponseContains($question['question']);
                //}
                break;
            case 'error':
                $this->assertResponseSuccess();
                $this->assertResponseCode(302);
                $this->assertRedirect(['_name' => 'users:login', '?' => ['redirect' => '/citizen']]);
                break;
        }
    }

    public function provideIndex(): array
    {
        return [
            'success' => [
                'expected' => 'success',
                'email' => UsersFixture::EMAIL_ADMIN,
            ],
            'error (unauthenticated)' => [
                'expected' => 'error',
            ],
        ];
    }
}
