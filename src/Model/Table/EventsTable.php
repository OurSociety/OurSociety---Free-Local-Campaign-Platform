<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Association\BelongsTo;

/**
 * EventsTable.
 *
 * @property BelongsTo|ElectoralDistrictsTable $ElectoralDistricts
 * @property BelongsTo|UsersTable $Users
 * @property BelongsTo|CategoriesTable $Categories
 */
class EventsTable extends AppTable
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Categories');
        $this->belongsTo('Users');
        $this->belongsTo('ElectoralDistricts');
    }
}
