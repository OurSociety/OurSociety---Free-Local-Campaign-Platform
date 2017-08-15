<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;
use Psr\Http\Message\ResponseInterface as Response;

class SearchController extends AppController
{
    public function zip(): ?Response
    {
        $zip = $this->request->getData('zip');
        if ($zip) {
            $this->redirect(['?' => compact('zip')]);
        }

        return null;
    }

    public function show(string $zip)
    {
        $query = <<<SQL
SELECT name, ST_AsGeoJSON(SHAPE) as polygon
FROM counties_reprojected
WHERE gnis IN (
    SELECT DISTINCT muni FROM (
        SELECT muni_l as muni
        FROM roads 
        WHERE zipcode_l = ?
        UNION ALL
        SELECT muni_r as muni
        FROM roads 
        WHERE zipcode_r = ?
    ) as munis
) ORDER BY name
SQL;

        $fetch = function (string $query, array $params, array $fieldNames): array {
            /** @var Connection $connection */
            $connection = ConnectionManager::get('default');
            $rows = $connection->execute($query, $params)->fetchAll();

            return collection($rows)
                ->map(function (array $row) use ($fieldNames): Entity {
                    return new Entity(array_combine($fieldNames, $row));
                })
                ->toArray();
        };

        $municipalities = $fetch($query, [$zip, $zip], ['name', 'polygon']);

        $query = <<<SQL
SELECT zcta5ce10 AS zip, ST_AsGeoJSON(SHAPE) AS polygon FROM zcta WHERE zcta5ce10 = ?
SQL;

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $zip = $fetch($query, [$zip], ['zip', 'polygon'])[0];

        $this->set(compact('zip', 'municipalities'));
    }

    public function search(): ?Response
    {
        return null;
    }
}
