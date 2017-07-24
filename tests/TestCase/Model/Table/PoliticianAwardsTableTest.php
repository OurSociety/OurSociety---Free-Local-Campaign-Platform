<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

/**
 * OurSociety\Model\Table\PoliticianAwardsTable Test Case
 */
class PoliticianAwardsTableTest extends AppTableTest
{
    public function provideValidationDefault(): array
    {
        return array_merge(parent::provideValidationDefault(), [
            // TODO: Check other fields
            'success (obtained is in past)' => [
                'field' => 'obtained',
                'value' => ['year' => '2010', 'month' => '01'],
            ],
            'success (obtained is NOT in past)' => [
                'field' => 'obtained',
                'value' => ['year' => '2010', 'month' => '01'],
            ],
        ]);
    }
}
