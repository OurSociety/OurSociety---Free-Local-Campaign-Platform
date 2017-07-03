<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Psy\Shell as PsyShell;

/**
 * Simple console wrapper around Psy\Shell.
 */
class ConsoleShell extends Shell
{

    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main(): ?int
    {
        if (!class_exists(PsyShell::class)) {
            $this->err('<error>Unable to load Psy\Shell.</error>');
            $this->err('');
            $this->err('Make sure you have installed psysh as a dependency,');
            $this->err('and that Psy\Shell is registered in your autoloader.');
            $this->err('');
            $this->err('If you are using composer run');
            $this->err('');
            $this->err('<info>$ php composer.phar require --dev psy/psysh</info>');
            $this->err('');

            return self::CODE_ERROR;
        }

        $this->out('You can exit with <info>`CTRL-C`</info> or <info>`exit`</info>');
        $this->out('');

        Log::drop('debug');
        Log::drop('error');
        $this->_io->setLoggers(false);
        restore_error_handler();
        restore_exception_handler();

        $psy = new PsyShell();

        return $psy->run();
    }

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser(): ConsoleOptionParser
    {
        $parser = new ConsoleOptionParser('console');
        $parser->setDescription(
            'This shell provides a REPL that you can use to interact ' .
            'with your application in an interactive fashion. You can use ' .
            'it to run adhoc queries with your models, or experiment ' .
            'and explore the features of CakePHP and your application.' .
            "\n\n" .
            'You will need to have psysh installed for this Shell to work.'
        );

        return $parser;
    }
}
