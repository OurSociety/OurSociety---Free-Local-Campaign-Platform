<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder;

use Cake\ORM\Query;

abstract class BooleanDateFinder extends Finder
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @var array
     */
    protected $options;

    public function __invoke(Query $query, array $options = []): Query
    {
        $this->query = $query;
        $this->options = $options;

        $defaultConditions = [
            $this->aliasField($this->query, $this->getFieldName(), 'IS NOT') => null,
        ];

        if ($this->hasBypassConditions()) {
            return $this->query->where(['or' => array_merge(
                $defaultConditions,
                $this->getBypassConditions()
            )]);
        }

        return $this->query->where($defaultConditions);
    }

    abstract protected function getFieldName(): string;

    protected function getBypassConditions(): array
    {
        return [];
    }

    protected function hasBypassConditions(): bool
    {
        return false;
    }
}
