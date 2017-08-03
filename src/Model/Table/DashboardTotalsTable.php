<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Query;

class DashboardTotalsTable extends AppTable
{
    public static function getTotal($name, $period)
    {
        return self::instance()->find()->where(compact('name', 'period'))->first() ?? new Entity();
    }

    public function initialize(array $config): void
    {
        $this->setPrimaryKey(['name', 'period']);

        parent::initialize($config);
    }

    public function recalculateTotals(): void
    {
        $entity = $this->find('usersCreated')->firstOrFail();
        $entity = $this->patchEntity($entity, ['percentage_change' => 10.3]);
        $this->saveOrFail($entity);
    }

    public function findUsersCreated(Query $query): Query
    {
        return $query->where(['name' => 'users_created', 'period' => 'hour'])->select([
            'name',
            'period',
            'count_current' => $this->query()->newExpr('100'),
            'count_previous' => 1000,
        ]);
    }

    public function findDashboard(Query $query, array $options): Query
    {
        $query->where(['period' => $options['period']]);

        if ($options['dashboard'] === 'users') {
            $query->where(['name IN' => [
                'users_created',
                'politicians_created',
                'citizens_created',
                'users_seen',
                'citizens_seen',
                'politicians_seen',
            ]]);
        }

        return $query;
    }
}
