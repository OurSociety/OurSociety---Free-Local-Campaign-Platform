<?php
declare(strict_types = 1);

namespace OurSociety\Listener;

use Cake\Cache\Cache;
use Cake\ORM\Association;
use Cake\Utility\Inflector;
use Crud\Listener as Crud;

class RelatedModelsListener extends Crud\RelatedModelsListener
{
    private const RECORD_LIMIT = 50;

    /**
     * {@inheritdoc}. Override to change variable name to match association foreign key.
     */
    public function publishRelatedModels($action = null, $entity = null): void
    {
        parent::publishRelatedModels();

        // Allows dropdown fields to be populated when using custom foreign key on association.
        // e.g. ElectoralDistricts belongsTo DistrictTypes, but foreign key is `type_id`:
        //      `$districtTypes` is populated by parent method, and here we copy it to `$types`.
        $setForeignKeyViewVar = function (Association $association): void {
            [$plugin, $associationName] = pluginSplit($association->getName());
            unset($plugin);

            $viewVar = Inflector::variable($associationName);
            if (!array_key_exists($viewVar, $this->_controller()->viewVars)) {
                return;
            }

            $assocForeignKey = $association->getForeignKey();
            $assocForeignKeyNoun = str_replace('_id', '', $assocForeignKey);
            $assocForeignKeyPluralNoun = Inflector::pluralize($assocForeignKeyNoun);
            $assocForeignKeyViewVar = Inflector::variable($assocForeignKeyPluralNoun);
            if ($viewVar === $assocForeignKeyViewVar) {
                return;
            }

            $this->_controller()->set($assocForeignKeyViewVar, $this->_controller()->viewVars[$viewVar]);
        };

        collection($this->models($action))
            ->each($setForeignKeyViewVar);
    }

    /**
     * {@inheritdoc}. Don't fetch records for tables with too many records.
     *
     * @param null $action
     * @return array
     */
    public function models($action = null): array
    {
        $models = parent::models($action);

        foreach ($models as $name => $association) {
            /** @var Association $association */
            $cacheKey = Inflector::underscore($name) . '_count';
            $count = Cache::remember($cacheKey, function () use ($association) {
                return $association->getTarget()->find()->count();
            });

            if ($count > self::RECORD_LIMIT) {
                unset($models[$name]);
            }
        }

        return $models;
    }
}
