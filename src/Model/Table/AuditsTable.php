<?php
declare(strict_types=1);

namespace OurSociety\Model\Table;

class AuditsTable extends AppTable
{
    public function getHourlyActivity(): array
    {
        $rows = $this->rawQuery('activity_by_hour');

        return debug($rows);
    }

    public function getCohorts(): array
    {
        $rows = $this->rawQuery('cohorts');

        $actual = [
            ['month' => '0', 'cohort' => '2017/08', 'percent_active' => '10.5263'],
            ['month' => '0', 'cohort' => '2017/09', 'percent_active' => '100.0000'],
            ['month' => '1', 'cohort' => '2017/07', 'percent_active' => '17.6471'],
            ['month' => '1', 'cohort' => '2017/08', 'percent_active' => '15.7895'],
            ['month' => '2', 'cohort' => '2017/07', 'percent_active' => '11.7647'],
        ];

        $expected = [
            'Month' => [
                '2017/07',
                '2017/08',
                '2017/09',
            ],
            0 => [
                '2017/07' => null,
                '2017/08' => '10.5263',
                '2017/09' => '100.0000',
            ],
            1 => [
                '2017/07' => '17.6471',
                '2017/08' => '15.7895',
                '2017/09' => null,
            ],
            2 => [
                '2017/07' => '11.7647',
                '2017/08' => null,
                '2017/09' => null,
            ],
        ];

        return $expected;

        //$cohorts = [];
        //foreach ($rows as $row) {
        //    $cohorts[$]
        //}

        $rows = collection($rows)->groupBy('month')->toArray();

        return debug($rows);
    }

    private function rawQuery(string $filename): array
    {
        $sqlFilename = CONFIG . 'Queries' . DS . 'Audits' . DS . $filename . '.sql';
        $sql = file_get_contents($sqlFilename);

        return $this->getConnection()->query($sql)->fetchAll('assoc');
    }
}
