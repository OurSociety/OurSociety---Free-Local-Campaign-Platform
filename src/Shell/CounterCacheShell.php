<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Counter Cache Shell.
 *
 * Provides a CLI interface to rebuild data provided by the CounterCache Behavior
 */
class CounterCacheShell extends Shell
{

    /**
     * Rebuild CounterCache data
     *
     * @param string|null $name The name of the table to build cache data for.
     * @return bool
     */
    public function build($name = null): bool
    {
        $schema = $this->_getSchema();
        if (!$schema) {
            return false;
        }
        $tables = [$name];
        if ($name === null) {
            $tables = $schema->listTables();
        }
        foreach ($tables as $table) {
            /** @var \Cake\ORM\Table $model */
            $model = TableRegistry::get($table);

            if ($model->hasBehavior('CounterCache')) {
                $this->_io->verbose('Rebuilding CounterCache for ' . $table);

                /** @var \Cake\ORM\Entity[] $results */
                $page = 1;
                $results = $model->find()->limit(50)->page($page++)->toArray();
                while (!empty($results)) {
                    foreach ($results as $entity) {
                        $entity->setDirty('modified', true);
                        $model->save($entity);
                    }
                    $results = $model->find()->limit(50)->page($page++)->toArray();
                }
            } else {
                $this->_io->verbose('No CounterCache found for ' . $table);
            }
        }
        $this->out('<success>CounterCache rebuild complete</success>');

        return true;
    }

    /**
     * Get the option parser for this shell.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->addSubcommand('build', [
            'help' => 'Build all CounterCache data for the connection. If a ' .
                'table name is provided, only that table will be cached.',
        ])->addOption('connection', [
            'help' => 'The connection to rebuild CounterCache data for.',
            'short' => 'c',
            'default' => 'default',
        ])->addArgument('name', [
            'help' => 'A specific table you want to rebuild CounterCache data for.',
            'optional' => true,
        ]);

        return $parser;
    }

    /**
     * Helper method to get the schema collection.
     *
     * @return false|\Cake\Database\Schema\Collection
     */
    protected function _getSchema()
    {
        $source = ConnectionManager::get($this->params['connection']);
        if (!method_exists($source, 'schemaCollection')) {
            $msg = sprintf(
                'The "%s" connection is not compatible with CounterCache Behavior, ' .
                'as it does not implement a "schemaCollection()" method.',
                $this->params['connection']
            );
            $this->error($msg);

            return false;
        }

        return $source->schemaCollection();
    }
}
