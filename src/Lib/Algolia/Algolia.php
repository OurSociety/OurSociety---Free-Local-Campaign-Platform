<?php
declare(strict_types=1);

namespace OurSociety\Lib\Algolia;

use AlgoliaSearch\Client;
use Cake\Datasource\ResultSetInterface;
use OurSociety\Model\Entity\SearchableEntity;

final class Algolia
{
    public const API_KEY_SEARCH = 'ALGOLIA_SEARCH_API_KEY';
    public const API_KEY_ADMIN = 'ALGOLIA_ADMIN_API_KEY';
    public const API_KEY_MONITORING = 'ALGOLIA_MONITORING_API_KEY';

    /**
     * @var Client
     */
    private $client;

    private function __construct(string $applicationId, string $apiKey)
    {
        $this->client = new Client($applicationId, $apiKey);
    }

    public static function createFromEnvironment(string $apiKeyEnvironmentVariable): self
    {
        $site = self::getEnvironmentVariable('ALGOLIA_APPLICATION_ID');
        $apiKey = self::getEnvironmentVariable($apiKeyEnvironmentVariable);

        return new self($site, $apiKey);
    }

    private static function getEnvironmentVariable(string $name): string
    {
        $value = env($name);

        if ($value === null) {
            throw new \InvalidArgumentException("Environment variable $${name} missing.");
        }

        return $value;
    }

    public function createIndex($string): void
    {
        $this->client->initIndex('places');
    }

    public function hasIndex(string $name): bool
    {
        dd($this->client->listIndexes());

        return true;
    }

    public function indexResults(ResultSetInterface $resultSet): void
    {
        if ($resultSet->count() === 0) {
            return;
        }

        $indexName = $resultSet->first()->searchableAs();

        $objects = $resultSet->map(function (SearchableEntity $entity) {
            return $entity->toSearchableArray() + ['objectID' => $entity->getKey()];
        });

        $this->client->initIndex($indexName)->addObjects($objects->toArray());
    }
}
