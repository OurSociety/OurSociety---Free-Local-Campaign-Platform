<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Validation;

use Cake\I18n\FrozenDate;
use OurSociety\TestSuite\TestCase;
use OurSociety\Validation\Validation;

/**
 * ValidationTest class
 */
class ValidationTest extends TestCase
{
    /**
     * @dataProvider provideYearMonth
     * @param bool $expected The expected result.
     * @param mixed $check The value to check.
     * @param array $options The validation options.
     */
    public function testYearMonth(bool $expected, $check, array $options = []): void
    {
        self::assertEquals($expected, Validation::yearMonth($check, $options));
    }

    public function provideYearMonth(): array
    {
        return [
            'success' => [
                'expected' => true,
                'check' => ['year' => '2010', 'month' => '05'],
            ],
            'success (future allowed)' => [
                'expected' => true,
                'check' => ['year' => '2020', 'month' => '05'],
                'options' => ['past' => false],
            ],
            'error (future NOT allowed)' => [
                'expected' => false,
                'check' => ['year' => '2020', 'month' => '05'],
            ],
            'error (invalid type)' => [
                'expected' => false,
                'check' => ['year' => 'invalid', 'month' => 05], // causes incorrect year
            ],
            'error (invalid value)' => [
                'expected' => false,
                'check' => ['year' => '2010', 'month' => 500], // causes internal Chronos exception
            ],
            'error (unhandled case)' => [
                'expected' => false,
                'check' => FrozenDate::now(), // causes internal Chronos exception
            ],
        ];
    }
}
