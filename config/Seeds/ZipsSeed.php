<?php
declare(strict_types=1);

use Cake\Filesystem\File;
use OurSociety\Console\Process\Ogr2ogr;
use OurSociety\Migration as App;

/**
 * Zips seeder.
 *
 * Adds zips to database from the US Census Bureau's ZIP Code Tabulation Areas (ZTCAs) data.
 */
class ZipsSeed extends App\AbstractSeed
{
    private const ZIPS_SOURCE = 'http://www2.census.gov/geo/tiger/GENZ2016/shp/cb_2016_us_zcta510_500k.zip';
    private const ZIPS_EXTRACT_DIRECTORY = TMP . 'seed_zips' . DS;
    private const ZIPS_FILENAME = TMP . 'seed_zips.zip';
    private const ZIPS_SOURCE_TABLE = 'cb_2016_us_zcta510_500k';

    public function run(): void
    {
        $this->download();
        $this->extract();
        $this->import();
        $this->seed();
        //$this->delete();
        //$http = new \Cake\Http\Client();
        //
        //$zipHtml = \Cake\Cache\Cache::remember('zip_html', function () use ($http) {
        //    return $http->get('http://www.nj.gov/nj/gov/direct/njzips.html')->getBody()->getContents();
        //});
        //
        //preg_match_all('#<td width="15%">(\d{5})</td>#', $zipHtml, $matches);
        //
        //if ($matches === false) {
        //    throw new RuntimeException('Regular expression error');
        //}
        //
        //$zips = array_unique($matches[1]);
        //sort($zips);
        //
        //$this->getOutput()->writeln(sprintf('Found %s ZIP codes on page.', count($zips)));
        //
        //$this->getOutput()->writeln(sprintf('"%s"', implode('","', [
        //    'hamlet',
        //    'village',
        //    'town',
        //    'city',
        //    'county',
        //    'postcode',
        //    'lat',
        //    'lon',
        //])));
        //
        //$missingZips = [];
        //collection($zips)
        //    ->each(function (string $zip) use ($http, &$missingZips) {
        //        $json = \Cake\Cache\Cache::remember(sprintf('zip_json_%s', $zip), function () use ($zip, $http) {
        //            return $http->get('http://nominatim.openstreetmap.org/', [
        //                'addressdetails' => true,
        //                'countrycodes' => 'us',
        //                'dedupe' => true,
        //                'format' => 'json',
        //                'limit' => 10,
        //                'postalcode' => $zip,
        //            ])->json;
        //        });
        //
        //        if (empty($json)) {
        //            $missingZips[] = $zip;
        //            return;
        //        }
        //
        //        collection($json)
        //            ->each(function (array $row) {
        //                $this->getOutput()->writeln(sprintf('"%s"', implode('","', [
        //                    $row['address']['hamlet'] ?? '',
        //                    $row['address']['village'] ?? '',
        //                    $row['address']['town'] ?? '',
        //                    $row['address']['city'] ?? '',
        //                    $row['address']['county'],
        //                    $row['address']['postcode'],
        //                    $row['lat'],
        //                    $row['lon'],
        //                ])));
        //            });
        //    });
        //
        //$this->getOutput()->writeln([sprintf("The following %d ZIPs were missing:\n", count($missingZips))] + $missingZips);
    }

    private function download(): void
    {
        $file = new File(self::ZIPS_FILENAME);
        if ($file->exists()) {
            $this->getOutput()->writeln(sprintf('Cached ZCTAs found in %s', self::ZIPS_FILENAME));
            return;
        }

        $this->getOutput()->writeln(sprintf('Downloading ZCTAs (~60M w/ 5 min timeout) to: %s', self::ZIPS_FILENAME));

        $http = new \Cake\Http\Client();
        $response = $http->get(self::ZIPS_SOURCE, [], ['redirect' => 1, 'timeout' => 5 * MINUTE]);

        $file->write($response->getBody()->getContents());
    }

    private function extract(): void
    {
        $file = new File(sprintf('%s%s.shp', self::ZIPS_EXTRACT_DIRECTORY, self::ZIPS_SOURCE_TABLE));
        if ($file->exists()) {
            $this->getOutput()->writeln(sprintf('Unzipped ZCTAs found in %s', self::ZIPS_EXTRACT_DIRECTORY));
            return;
        }

        $this->getOutput()->writeln(sprintf('Unzipping files to %s', self::ZIPS_EXTRACT_DIRECTORY));

        $zip = new ZipArchive;
        if ($zip->open(self::ZIPS_FILENAME) === TRUE) {
            $zip->extractTo(self::ZIPS_EXTRACT_DIRECTORY);
            $zip->close();
            $this->getOutput()->writeln('Unzipped files.');
        } else {
            throw new \RuntimeException('Failed to unzip files.');
        }
    }

    private function import(): void
    {
        if ($this->table(self::ZIPS_SOURCE_TABLE)->exists()) {
            $this->getOutput()->writeln('ZCTAs table already exists - assuming it has been imported.');

            return;
        }

        $this->getOutput()->writeln('Importing shapes to database');
        $adapterOptions = $this->getAdapter()->getOptions();

        $query = <<<SQL
SELECT zcta5ce10 as zcta FROM cb_2016_us_zcta510_500k WHERE CAST(zcta5ce10 AS INTEGER) > 07000 AND CAST(zcta5ce10 AS INTEGER) < 09000
SQL;
        $ogr2ogrProcess = new Ogr2ogr(self::ZIPS_EXTRACT_DIRECTORY, $adapterOptions, $query, 'gis_zips');
        //$ogr2ogrProcess->setSql($query);
        //$ogr2ogrProcess->setNewLayerName('tmp_zctas');
        $output = $ogr2ogrProcess->run();
        $this->getOutput()->write($output);
    }

    private function seed(): void
    {
        $sql = <<<SQL
INSERT INTO zips (id, zip)
SELECT uuid(), zcta
FROM %s
SQL;
        $this->execute(sprintf($sql, self::ZIPS_SOURCE_TABLE));
    }

    private function delete(): void
    {
        $this->table(self::ZIPS_SOURCE_TABLE)->drop();
        $this->table('geometry_columns')->drop();
        $this->table('spatial_ref_sys')->drop();
    }
}
