<?php
declare(strict_types=1);

use OurSociety\Migration as App;

/**
 * Database seeder.
 *
 * Seeds the entire database by running all the other seeders.
 */
class DatabaseSeed extends App\AbstractSeed
{
    /**
     * Ordered list of seeder classes to call.
     *
     * @var string[]
     */
    private static $seeders = [
        CategoriesSeed::class,
        QuestionsSeed::class,
    ];

    /**
     * Calls each seeder class in order.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (self::$seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
