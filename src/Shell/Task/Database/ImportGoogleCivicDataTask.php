<?php
declare(strict_types=1);

namespace OurSociety\Shell\Task\Database;

use Cake\Cache\Cache;
use Cake\Console\Shell;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Table\ElectoralDistrictsTable;
use OurSociety\Model\Table\OfficesTable;
use RuntimeException;

class ImportGoogleCivicDataTask extends Shell
{
    public function importDivisions(): int
    {
        ini_set('memory_limit', '-1');

        $ocdId = 'ocd-division/country:us/state:nj';

        /** @var \Google_Service_CivicInfo_RepresentativeInfoData $info */
        $info = Cache::remember($ocdId, function () use ($ocdId) {
            $client = new \Google_Client();
            $client->setApplicationName('OurSociety');
            $client->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));

            return (new \Google_Service_CivicInfo($client))
                ->representatives
                ->representativeInfoByDivision($ocdId, ['recursive' => true]);
        });

        /** @var ElectoralDistrictsTable $table */
        $table = TableRegistry::get('ElectoralDistricts');
        foreach ($info->getDivisions() as $ocdId => $geographicDivision) {
            if (strpos($ocdId, '/precinct:')) {
                continue;
            }

            if (strpos($ocdId, '/school_district:')) {
                continue;
            }

            /** @var \Google_Service_CivicInfo_GeographicDivision $geographicDivision */
            $table->upsert(['ocd_id' => $ocdId], [
                'name' => $geographicDivision->getName(),
                'office_count' => count($geographicDivision->getOfficeIndices()),
            ]);
        }

        return self::CODE_SUCCESS;
    }

    public function importOffices(): int
    {
        ini_set('memory_limit', '-1');

        $ocdId = 'ocd-division/country:us/state:nj';

        /** @var \Google_Service_CivicInfo_RepresentativeInfoData $info */
        $info = Cache::remember($ocdId, function () use ($ocdId) {
            $client = new \Google_Client();
            $client->setApplicationName('OurSociety');
            $client->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));

            return (new \Google_Service_CivicInfo($client))
                ->representatives
                ->representativeInfoByDivision($ocdId, ['recursive' => true]);
        });

        /** @var \Google_Service_CivicInfo_Office[] $offices */
        $offices = $info->getOffices();
        foreach ($offices as $office) {
            /** @var OfficesTable $table */
            $table = TableRegistry::get('Offices');
            /** @var ElectoralDistrict $electoralDistrict */
            $electoralDistrict = $table->ElectoralDistricts->findByIdOcd($office->getDivisionId())->firstOrFail();
            $table->saveOrFail($table->newEntity([
                'name' => $office->getName(),
                'electoral_district_id' => $electoralDistrict->id,
            ]));
        }
        ///** @var ElectoralDistrictsTable $table */
        //$table = TableRegistry::get('ElectoralDistricts');
        //foreach ($info->getDivisions() as $ocdId => $geographicDivision) {
        //    if (strpos($ocdId, '/precinct:')) {
        //        continue;
        //    }
        //
        //    if (strpos($ocdId, '/school_district:')) {
        //        continue;
        //    }
        //
        //    /** @var \Google_Service_CivicInfo_GeographicDivision $geographicDivision */
        //    $table->upsert(['id_ocd' => $ocdId], [
        //        'name' => $geographicDivision->getName(),
        //        'office_count' => count($geographicDivision->getOfficeIndices()),
        //    ]);
        //}

        return self::CODE_SUCCESS;
    }

    public function mapMunicipalities(): int
    {
        $html = Cache::remember('nj_municipalities', function () {
            return (string)(new Client)->get('http://www.njleg.state.nj.us/districts/municipalities.asp')->getBody();
        });

        $actualCount = preg_match_all('!<a href="districtnumbers.asp#(\d{1,2})"><b>(.*?)( \((.*?)\))?</b></a>!', $html, $matches);
        $expectedCount = 567;

        if ($actualCount !== $expectedCount) {
            throw new RuntimeException('Regex error');
        }

        /** @var ElectoralDistrictsTable $table */
        $table = TableRegistry::get('ElectoralDistricts');

        for ($i = 0; $i < $actualCount; $i++) {
            $number = $matches[1][$i];
            $place = $matches[2][$i];
            $county = $matches[4][$i];

            $conditions = [
                [
                    'id_ocd LIKE' => sprintf(
                        '%%ocd-division/country:us/state:nj/%%%s%%place:%s',
                        Text::slug(strtolower($county), ['replacement' => '_']),
                        Text::slug(strtolower($place), ['replacement' => '_'])
                    )
                ],
                [
                    'slug' => Text::slug(strtolower($place))
                ],
                [
                    'slug' => sprintf('%s-town', Text::slug(strtolower($place)))
                ],
                [
                    'slug' => sprintf('%s-city', Text::slug(strtolower($place)))
                ],
                [
                    'slug' => sprintf('%s-borough', Text::slug(strtolower($place)))
                ],
                [
                    'slug' => sprintf('city-of-%s-township', Text::slug(strtolower($place)))
                ],
                [
                    'slug' => sprintf('%s-village-township', Text::slug(strtolower($place)))
                ],
                [
                    'id_ocd LIKE' => sprintf(
                        '%%ocd-division/country:us/state:nj/%%%s%%place:%s',
                        Text::slug(strtolower($county), ['replacement' => '_']),
                        str_replace('peapack_gladstone', 'peapack_and_gladstone', Text::slug(strtolower($place), ['replacement' => '_']))
                    )
                ],
            ];

            $exactMatch = false;
            foreach ($conditions as $condition) {
                $query = $table->find()->where($condition);
                if ($query->count() === 1) {
                    $exactMatch = true;
                    break;
                }
            }

            if ($exactMatch === false) {
                $this->err('No exact match for ' . json_encode($conditions));
                /** @noinspection PhpUndefinedVariableInspection */

                return self::CODE_ERROR;
            }

            $municipalityType = TableRegistry::get('DistrictTypes')->findByName('municipality')->firstOrFail();
            $parentDistrict = $table->findByOcdId('ocd-division/country:us/state:nj/sldu:' . $number)->firstOrFail();

            /** @var ElectoralDistrict $district */
            /** @noinspection PhpUndefinedVariableInspection */
            $district = $query->firstOrFail();
            $this->out('Updating ' . $district->id_ocd);

            $saved = $table->saveOrFail($table->patchEntity($district, [
                'parent_id' => $parentDistrict->id,
                'type_id' => $municipalityType->id,
            ]));
        }

        return self::CODE_SUCCESS;
    }
}
