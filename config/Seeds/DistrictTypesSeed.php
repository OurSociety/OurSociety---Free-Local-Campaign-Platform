<?php
declare(strict_types=1);

use Cake\Utility\Text;
use OurSociety\Migration as App;

/**
 * DistrictTypes seeder.
 *
 * Seeds the `users` table with an admin user. Use the "forgot password" to set the initial password.
 */
class DistrictTypesSeed extends App\AbstractSeed
{
    public function run(): void
    {
        $table = $this->table('district_types');
        $abort = $this->assertEmptyTable($table);
        if ($abort) {
            return;
        }

        $data = [
            [
                'id' => Text::uuid(),
                'name' => 'borough',
                'description' => 'A borough',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'city',
                'description' => 'A city.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'city-council',
                'description' => 'A specific seat/jurisdiction for a city, town, or village council.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'congressional',
                'description' => 'A United States congressional district.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'county',
                'description' => 'A county.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'county-council',
                'description' => 'A county council district, either in its entirety or for a specific seat.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'judicial',
                'description' => 'A judicial district.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'municipality',
                'description' => 'A civil division which is not a town, city, village, or county.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'national',
                'description' => 'The United States.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'school',
                'description' => 'A school district.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'special',
                'description' => 'A special-purpose district that exist separate from general-purpose districts.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'state',
                'description' => 'A state, district, commonwealth, or U.S. territory.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'state-house',
                'description' => 'The lower house of a state legislature.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'state-senate',
                'description' => 'The upper house of a state legislature.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'town',
                'description' => 'A town.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'township',
                'description' => 'A township, which may be different than a town. See the Wikipedia article.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'utility',
                'description' => 'A non-water public or municipal utility district.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'village',
                'description' => 'A village district.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'ward',
                'description' => 'A ward.',
            ],
            [
                'id' => Text::uuid(),
                'name' => 'water',
                'description' => 'A water district.',
            ],
        ];

        $table->insert($data)->save();
    }
}
