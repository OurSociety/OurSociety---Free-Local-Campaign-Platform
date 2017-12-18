<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Events;

use Cake\ORM\Query;
use InvalidArgumentException;
use OurSociety\Model\Table\Finder\Finder;

class ForIndexActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $municipality = $options['municipality'] ?? null;

        if ($municipality === null) {
            throw new InvalidArgumentException('Missing "municipality" finder option.');
        }

        return $query
            ->select([
                $this->aliasField($query, 'id'),
                $this->aliasField($query, 'name'),
                $this->aliasField($query, 'location'),
                $this->aliasField($query, 'start'),
            ])
            ->matching('ElectoralDistricts', function (Query $query) use ($municipality): Query {
                return $query->where([
                    $this->aliasField($query, 'slug') => $municipality,
                ]);
            })
            ->orderAsc($this->aliasField($query, 'start'));
    }
}
