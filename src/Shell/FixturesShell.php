<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use OurSociety\TestSuite\Fixture\DatabaseFixture;

class FixturesShell extends Shell
{
    public function getOptionParser(): ConsoleOptionParser
    {
        return parent::getOptionParser()
            ->addSubcommand('dump', ['help' => 'Dump SQL file from fixtures connection'])
            ->addSubcommand('migrate', ['help' => 'Run migrations on fixtures connection'])
            ->addSubcommand('restore', ['help' => 'Import SQL file into fixtures connection'])
            ->addSubcommand('rollback', ['help' => 'Rollback migrations on fixtures connection']);
    }

    public function main(): bool
    {
        $this->out($this->OptionParser->help());

        return true;
    }

    public function dump(): bool
    {
        (new DatabaseFixture)->dumpFixtureDatabase();

        $this->success('Fixtures database dumped to file.');

        return true;
    }

    public function migrate(): bool
    {
        $this->dispatchShell('migrations migrate --connection=fixtures');
        $this->dispatchShell('fixtures dump');

        return true;
    }

    public function restore(): bool
    {
        (new DatabaseFixture)->restoreFixtureDatabase();

        $this->success('Fixtures database restored from file.');

        return true;
    }

    public function rollback(): bool
    {
        $this->dispatchShell('migrations rollback --connection=fixtures');

        return true;
    }
}
