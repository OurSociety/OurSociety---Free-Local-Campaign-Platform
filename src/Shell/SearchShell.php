<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Table;
use OurSociety\Model\Entity\Traits\SearchableTrait;
use OurSociety\ORM\TableRegistry;
use OurSociety\Lib\Algolia\Algolia;
use OurSociety\Model\Behavior\SearchEngineBehavior;
use OurSociety\Model\Entity\AppEntity;

class SearchShell extends AppShell
{
    public function getOptionParser(): ConsoleOptionParser
    {
        return parent::getOptionParser()
            ->addOption('connection', [
                'help' => 'The connection to import search data from.',
                'short' => 'c',
                'default' => 'default',
            ])
            ->addSubcommand('import', [
                'help' => 'Import searchable data into search engine.'
            ])
            ->addSubcommand('migrate', [
                'help' => 'Create/migrate search engine indexes.'
            ]);
    }

    /**
     * @return bool|int|null Success or error code.
     */
    public function migrate(): bool
    {
        $search = Algolia::createFromEnvironment(Algolia::API_KEY_ADMIN);

        $createIndexIfMissing = function (string $name) use ($search) {
            if ($search->hasIndex($name)) {
                $this->out(sprintf('Index "%s" exists.', $name));
                return;
            }

            $search->createIndex($name);
            $this->out(sprintf('Index "%s" created.', $name));
        };

        $createIndexIfMissing('places');

        return true;
    }

    public function import(string $name = null): bool
    {
        if ($name !== null) {
            $this->importTable(TableRegistry::get($name, ['connection' => $this->params['connection']]));
        } else {
            $this->importTables();
        }

        $this->out('<success>Search data imported</success>');
        return true;
    }

    private function importTables(): void
    {
        $tableCollection = TableRegistry::all(['connection' => $this->params['connection']]);
        $tableCollection->each(function (Table $table): void {
            $this->importTable($table);
        });
        //foreach ($this->getSchema()->listTables() as $table) {
        //    $this->importTable($table);
        //}
    }

    private function importTable(Table $table): void
    {
        if (!$table->hasBehavior(SearchEngineBehavior::class)) {
            return;
        }

        $this->_io->verbose('Importing data for ' . $table->getAlias());

        /** @var Table|SearchEngineBehavior $table */
        $searchFinder = $table->getSearchFinder();

        $page = 1;
        $search = Algolia::createFromEnvironment(Algolia::API_KEY_ADMIN);
        do {
            $results = $table->find($searchFinder)->limit(50)->page($page++)->all();
            d($results->count());
            $search->indexResults($results);
        } while ($results->count());
    }

    //public function import($model): bool
    //{
    //    $this->eve
    //    $model = TableRegistry::get($model);
    //    $events->listen(ModelsImported::class, function ($event) use ($class) {
    //        $key = $event->models->last()->getKey();
    //        $this->line('<comment>Imported ['.$class.'] models up to ID:</comment> '.$key);
    //    });
    //    $model::makeAllSearchable();
    //    $events->forget(ModelsImported::class);
    //    $this->info('All ['.$class.'] records have been imported.');
    //
    //
    //    $model::makeAllSearchable();
    //}
}
