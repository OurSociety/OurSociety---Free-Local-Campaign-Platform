<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Shell\Helper\ProgressHelper;
use OurSociety\Model\Table\AnswersTable;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Table\AppTable;
use OurSociety\Shell\Task\Database\ImportGoogleCivicDataTask;

/**
 * @property ImportGoogleCivicDataTask $ImportGoogleCivicData
 */
class DatabaseShell extends AppShell
{
    public function initialize(): void
    {
        $this->tasks = [
            'ImportGoogleCivicData' => ['className' => Task\Database\ImportGoogleCivicDataTask::class],
        ];

        parent::initialize();
    }

    public function getOptionParser(): ConsoleOptionParser
    {
        return parent::getOptionParser()
            ->addSubcommand('recalculate_matches', [
                'help' => 'Recalculate all value match percentages',
                'parser' => new ConsoleOptionParser('recalculate_matches', [
                    'help' => <<<HELP
Triggers the afterSave callback on each answer in the system.
This callback contains the logic that calculates value match percentages between the users who answered that question.
HELP
                ]),
            ])
            ->addSubcommand('recalculate_dashboards', [
                'help' => 'Recalculate all dashboard totals',
                'parser' => new ConsoleOptionParser('recalculate_dashboards', [
                    'help' => <<<HELP
Triggers the afterSave callback on each answer in the system.
This callback contains the logic that calculates dashboard totals between the users who answered that question.
HELP
                ]),
            ]);
    }

    public function main(): int
    {
        $this->out($this->OptionParser->help());

        return self::CODE_SUCCESS;
    }

    public function importGoogleCivicData(): int
    {
        //return $this->ImportGoogleCivicData->importDivisions();
        //return $this->ImportGoogleCivicData->mapMunicipalities();
        return $this->ImportGoogleCivicData->importOffices();
    }

    public function recalculateMatches(): int
    {
        /** @var AnswersTable $table */
        $table = TableRegistry::get('answers');
        $answers = $table->find()->all();

        /** @var Answer[] $answersArray */
        $answersArray = $answers->toArray();
        $index = 0;

        /** @var ProgressHelper $progress */
        $progress = $this->helper('Progress');
        $progress->output([
            'total' => $answers->count(),
            'callback' => function (ProgressHelper $progress) use ($answersArray, &$index) {
                $progress->increment();
                $this->recalculateMatch($answersArray[$index]);
                $index++;
            },
        ]);

        return self::CODE_SUCCESS;
    }

    public function updateSlugs(): int
    {
        /** @var AppTable $table */
        $table = TableRegistry::get('ElectoralDistricts');
        $hasSlugsWithNumbers = $table->find()->where(['slug RLIKE' => '\d$'])->all();
        foreach ($hasSlugsWithNumbers as $hasSlugWithNumber) {
            $hasSlugWithNumber->slug = $table->slug($hasSlugWithNumber);
            $table->saveOrFail($hasSlugWithNumber);
        }

        return self::CODE_SUCCESS;
    }

    public function recalculateDashboards(): bool
    {
        /** @var DashboardTotalsTable $table */
        $table = TableRegistry::get('DashboardTotals');
        $table->recalculateTotals();

        return self::CODE_SUCCESS;
    }

    private function recalculateMatch(Answer $answer): void
    {
        /** @var AnswersTable $table */
        $table = TableRegistry::get('answers');
        $table->afterSave(new Event('afterSave'), $answer, new ArrayObject());
    }
}
