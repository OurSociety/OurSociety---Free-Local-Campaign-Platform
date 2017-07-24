<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

/**
 * OurSociety\Model\Table\PoliticianPositionsTable Test Case
 */
class PoliticianPositionsTableTest extends AppTableTest
{
    public function provideValidationDefault(): array
    {
        return array_merge(parent::provideValidationDefault(), [
            // TODO: Check other fields
            'success (started is in past)' => [
                'field' => 'started',
                'value' => ['year' => '2010', 'month' => '01'],
            ],
            'success (started is NOT in past)' => [
                'field' => 'started',
                'value' => ['year' => '2010', 'month' => '01'],
            ],
            'success (ended is in past)' => [
                'field' => 'ended',
                'value' => ['year' => '2010', 'month' => '01'],
            ],
            'success (ended is NOT in past)' => [
                'field' => 'ended',
                'value' => ['year' => '2010', 'month' => '01'],
            ],
        ]);
    }
}
