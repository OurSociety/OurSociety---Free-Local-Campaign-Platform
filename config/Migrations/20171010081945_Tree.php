<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class Tree extends AbstractMigration
{
    public function up(): void
    {
        //$this->dropNodesTable();
        $this->createNodesTable();
        //sleep(1);
        $this->populateNodesTable();
    }

    public function down(): void
    {
        $this->dropNodesTable();
    }

    private function createNodesTable(): void
    {
        $this->table('nodes', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('table', 'string', ['null' => false])
            ->addColumn('foreign_key', 'uuid', ['null' => false])
            ->addColumn('parent_id', 'uuid', ['null' => true])
            ->addColumn('level', 'integer', ['null' => true])
            ->addColumn('lft', 'integer', ['null' => true])
            ->addColumn('rght', 'integer', ['null' => true])
            ->create();
    }

    private function dropNodesTable(): void
    {
        $this->table('nodes')
            ->drop();
    }

    private function populateNodesTable(): void
    {
        /** @var \OurSociety\Model\Table\ElectoralDistrictsTable $placesTable */
        $placesTable = \OurSociety\ORM\TableRegistry::get('ElectoralDistricts');
        /** @var \OurSociety\Model\Table\NodesTable $nodesTable */
        $nodesTable = \OurSociety\ORM\TableRegistry::get('Nodes');

        $page = 1;
        do {
            $places = $placesTable->find()->orderAsc('id_ocd')->limit(50)->page($page++)->all();

            //$mapPlaceToNode = function (\OurSociety\Model\Entity\ElectoralDistrict $place) use ($nodesTable) {
            //    return $nodesTable->newEntity([
            //        'id' => $place->id,
            //        //'table' => 'electoral_districts',
            //        'foreign_key' => $place->id,
            //        'parent_id' => $place->parent_id,
            //    ]);
            //};
            //
            //$nodes = $places->map($mapPlaceToNode)->toArray();
            //
            //$nodesTable->saveMany($nodes);

            $places->each(function (\OurSociety\Model\Entity\ElectoralDistrict $place) use ($nodesTable) {
                $node = $nodesTable->newEntity([
                    'id' => 'help', //$place->id,
                    //'table' => 'electoral_districts',
                    'foreign_key' => $place->id,
                    'parent_id' => $place->parent_id,
                ]);
                $saved = $nodesTable->save($node);
                //dd($node->getErrors());
            });

        } while ($places->count());
    }
}
