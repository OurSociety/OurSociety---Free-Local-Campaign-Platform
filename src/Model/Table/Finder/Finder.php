<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder;

use Cake\ORM\Query;
use Cake\ORM\Table;
use OurSociety\Model\Entity\User;

/**
 * Finder.
 *
 * Base class for all invokable finders.
 */
abstract class Finder
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * Constructor.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Logic for the custom finder goes here.
     *
     * @param Query $query The original query.
     * @param array $options Any options for the find call.
     * @return Query The custom query.
     */
    abstract public function __invoke(Query $query, array $options = []): Query;

    /**
     * Alias field.
     *
     * Cake's method returns an array, which is almost never what we want.
     *
     * @param Query $query The query to get the correct alias from.
     * @param string $field The field name to alias.
     * @param string|null $operator The operator to append, if any. ('LIKE', '>', etc.)
     * @return string The alias.
     */
    protected function aliasField(Query $query, string $field, string $operator = null): string
    {
        $aliasedField = $query->aliasField($field);
        $aliasedFieldName = array_values($aliasedField)[0];

        if ($operator !== null) {
            $aliasedFieldName .= ' ' . $operator;
        }

        return $aliasedFieldName;
    }

    protected function hasIdentity($options): bool
    {
        $identity = $options['identity'] ?? null;

        return $identity instanceof User;
    }

    protected function getIdentity($options): User
    {
        return $options['identity'];
    }
}
