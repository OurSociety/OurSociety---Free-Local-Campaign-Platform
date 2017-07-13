<?php
declare(strict_types = 1);

namespace OurSociety\Migration;

use Iterator;
use League\Csv\Reader;
use Phinx\Db\Table;
use Migrations;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;

abstract class AbstractSeed extends Migrations\AbstractSeed
{
    protected function assertEmptyTable(Table $table): void
    {
        if (!$this->isTableEmpty($table)) {
            if ($this->confirm('Do you want to truncate the table first')) {
                $this->truncateTable($table);
            } else {
                $this->error('Questions seed already imported');
            }
        }
    }

    protected function confirm(string $message)
    {
        if (!$this->getInput()->isInteractive()) {
            return false;
        }

        $this->getOutput()->writeln('');

        $answer = (new QuestionHelper)->ask(
            $this->getInput(),
            $this->getOutput(),
            new ConfirmationQuestion(sprintf(' <error>%s (y/N)?</error> ', $message), false)
        );

        $this->getOutput()->writeln('');

        return $answer;
    }

    protected function error(string $message): void
    {
        $this->getOutput()->writeln(sprintf(' <error>%s</error>', $message));

        exit(1);
    }

    protected function getCsvRecords(string $filename): Iterator
    {
        return Reader::createFromPath(CONFIG . 'Seeds' . DS . $filename)
            ->setHeaderOffset(0)
            ->getRecords();
    }

    protected function getRowCount(Table $table): int
    {
        $name = $table->getName();
        $sql = "SELECT COUNT(*) as count FROM ${name}";
        $row = $table->getAdapter()->fetchRow($sql);

        return (int)$row['count'];
    }

    protected function isTableEmpty(Table $table): bool
    {
        return $this->getRowCount($table) === 0;
    }

    protected function truncateTable(Table $table): void
    {
        $name = $table->getName();
        $sql = "TRUNCATE ${name}";
        $table->getAdapter()->execute($sql);
    }
}
