<?php
declare(strict_types=1);

use OurSociety\Migration as App;

/**
 * District seeder.
 *
 * Seeds the entire database by running all the other seeders.
 */
class DistrictSeed extends App\AbstractSeed
{
    public function run(): void
    {
        $http = new \Cake\Http\Client();

        $zipHtml = \Cake\Cache\Cache::remember('zip_html', function () use ($http) {
            return $http->get('http://www.nj.gov/nj/gov/direct/njzips.html')->getBody()->getContents();
        });

        preg_match_all('#<td width="15%">(\d{5})</td>#', $zipHtml, $matches);

        if ($matches === false) {
            throw new RuntimeException('Regular expression error');
        }

        $zips = array_unique($matches[1]);
        sort($zips);

        $this->getOutput()->writeln(sprintf('Found %s ZIP codes on page.', count($zips)));

        $this->getOutput()->writeln(sprintf('"%s"', implode('","', [
            'hamlet',
            'village',
            'town',
            'city',
            'county',
            'postcode',
            'lat',
            'lon',
        ])));

        $missingZips = [];
        collection($zips)
            ->each(function (string $zip) use ($http, &$missingZips): void {
                $json = \Cake\Cache\Cache::remember(sprintf('zip_json_%s', $zip), function () use ($zip, $http) {
                    return $http->get('http://nominatim.openstreetmap.org/', [
                        'addressdetails' => true,
                        'countrycodes' => 'us',
                        'dedupe' => true,
                        'format' => 'json',
                        'limit' => 10,
                        'postalcode' => $zip,
                    ])->json;
                });

                if (empty($json)) {
                    $missingZips[] = $zip;

                    return;
                }

                collection($json)
                    ->each(function (array $row): void {
                        $this->getOutput()->writeln(sprintf('"%s"', implode('","', [
                            $row['address']['hamlet'] ?? '',
                            $row['address']['village'] ?? '',
                            $row['address']['town'] ?? '',
                            $row['address']['city'] ?? '',
                            $row['address']['county'],
                            $row['address']['postcode'],
                            $row['lat'],
                            $row['lon'],
                        ])));
                    });
            });

        $this->getOutput()->writeln([sprintf("The following %d ZIPs were missing:\n", count($missingZips))] + $missingZips);
    }
}
