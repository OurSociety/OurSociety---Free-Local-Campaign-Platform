<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Fixture;

use Cake\TestSuite\Fixture as Cake;
use Faker\Factory as GeneratorFactory;
use Faker\Generator;

class TestFixture extends Cake\TestFixture
{
    /**
     * @var Generator
     */
    public $generator;

    public $defaults = [];

    public function init(): void
    {
        parent::init();

        $this->generator = GeneratorFactory::create();
        $this->generator->seed(SEED);

        $setDefaults = function (array $record) {
            return $record + $this->defaults;
        };

        $setDates = function (array $record) {
            foreach ($record as $field => $value) {
                if (is_string($value) && $this->fields[$field]['type'] === 'datetime') {
                    $record[$field] = strtotime($value);
                }
            }

            return $record;
        };

        $setIds = function (array $record) {
            if (!isset($record['id'])) {
                $record['id'] = $this->generator->uuid;
            }

            return $record;
        };

        $this->records = collection($this->records)
            ->map($setIds)
            ->map($setDefaults)
            ->map($setDates);
    }
}
