<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Table;
use OurSociety\Lib\Algolia\Algolia;
use OurSociety\Model\Behavior\SearchEngineBehavior;
use OurSociety\ORM\TableRegistry;

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
                'help' => 'Import searchable data into search engine.',
            ])
            ->addSubcommand('migrate', [
                'help' => 'Create/migrate search engine indexes.',
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
            $this->importTable(TableRegistry::get($name, $this->getTableRegistryOptions()));
        } else {
            $this->importTables();
        }

        $this->out('<success>Search data imported</success>');

        return true;
    }

    private function getTableRegistryOptions(): array
    {
        return ['connection' => $this->params['connection']];
    }

    private function importTables(): void
    {
        $tableCollection = TableRegistry::all($this->getTableRegistryOptions());
        $tableCollection->each(function (Table $table): void {
            $this->importTable($table);
        });
    }

    private function importTable(Table $table): void
    {
        if (!$table->hasBehavior(SearchEngineBehavior::class)) {
            return;
        }

        /** @var Table|SearchEngineBehavior $table */
        $searchFinder = $table->getSearchFinder();
        $tableAlias = $table->getAlias();
        $algolia = Algolia::createFromEnvironment(Algolia::API_KEY_ADMIN);
        $pageLimit = 50;
        $pageNumber = 1;
        $query = $table->find($searchFinder)->limit($pageLimit);
        $remaining = $query->count();

        $this->_io->out(sprintf('Importing %d records into "%s" index in batches of %d...', $remaining, $tableAlias, $pageLimit));

        do {
            $page = $query->page($pageNumber++)->all();
            $count = $page->count();
            $algolia->indexResults($page);
            $this->_io->out('.', 0);
        } while ($count > 0);

        $this->_io->out();
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
