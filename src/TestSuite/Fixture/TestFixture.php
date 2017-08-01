<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Fixture;

use Cake\TestSuite\Fixture as Cake;
use Faker\Factory as GeneratorFactory;
use Faker\Generator;
use Muffin\Slug\Slugger\CakeSlugger;

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
        //$this->generator->seed(SEED);

        $setDefaults = function (array $record) {
            return $record + $this->defaults;
        };

        $setDates = function (array $record) {
            foreach ($record as $field => $value) {
                if (!isset($this->fields[$field])) {
                    continue;
                }
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

        $setSlugs = function (array $record) {
            if (!array_key_exists('slug', $this->fields)) {
                return $record;
            }

            $record['slug'] = $record['slug'] ?? (new CakeSlugger)->slug($record['name']);

            return $record;
        };

        $this->records = collection($this->records)
            ->map($setIds)
            ->map($setDefaults)
            ->map($setSlugs)
            ->map($setDates)
            ->toArray();
    }
}
