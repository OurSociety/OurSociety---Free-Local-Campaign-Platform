<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use ArrayObject;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Shell\Helper\ProgressHelper;
use OurSociety\Model\Table\AnswersTable;
use OurSociety\Model\Entity\Answer;

class DatabaseShell extends Shell
{
    public function getOptionParser(): ConsoleOptionParser
    {
        return parent::getOptionParser();
    }

    public function main(): bool
    {
        $this->out($this->OptionParser->help());

        return true;
    }

    public function recalculateMatches(): bool
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

        return true;
    }

    private function recalculateMatch(Answer $answer): void
    {
        /** @var AnswersTable $table */
        $table = TableRegistry::get('answers');
        $table->afterSave(new Event('afterSave'), $answer, new ArrayObject());
    }
}
