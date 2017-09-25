<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\AppController;

/**
 * Admin dashboard.
 */
class DashboardController extends AppController
{
    /**
     * @route GET /admin
     * @routeName admin:dashboard
     * @return Response|null
     */
    public function dashboard(): ?Response
    {
        return $this->redirect(['_name' => 'admin:users:dashboard']);

        $users = $this->loadModel('Users');

        switch ($this->request->getQuery('range', 'week')) {
            case 'week': $days = 7; break;
            case 'month': $days = 31; break;
            case 'year': $days = 365; break;
            default: throw new NotFoundException('Invalid range');
        }

        $this->set([
            'totalCount' => $users->find()->count(),
            'activeCount' => $users->find()->where(['Users.last_seen >' => Time::now()->subMinutes(15)])->count(),
            'verifiedCount' => $users->find()->where(['Users.verified IS NOT' => null])->count(),
            'unverifiedCount' => $users->find()->where(['Users.verified IS' => null])->count(),
            'adminCount' => $users->find()->where(['Users.role' => User::ROLE_ADMIN])->count(),
            'citizenCount' => $users->find()->where(['Users.role' => User::ROLE_CITIZEN])->count(),
            'politicianCount' => $users->find()->where(['Users.role' => User::ROLE_POLITICIAN])->find('isVerified')->count(),
            'weeklyIncrease' => $users->query()->getConnection()->execute(<<<SQL
SELECT (
	(SELECT COUNT(*) FROM users WHERE last_seen > NOW() - INTERVAL $days DAY + INTERVAL $days DAY) /
	(SELECT COUNT(*) FROM users WHERE last_seen < NOW() - INTERVAL $days DAY AND last_seen > NOW() - INTERVAL $days DAY - INTERVAL $days DAY)
) * 100 AS weekly_increase
SQL
            )->fetch()[0],
            'monthlyIncrease' => $users->query()->getConnection()->execute(<<<SQL
SELECT (
	(SELECT COUNT(*) FROM users WHERE last_seen > NOW() - INTERVAL $days DAY + INTERVAL $days DAY) /
	(SELECT COUNT(*) FROM users WHERE last_seen < NOW() - INTERVAL $days DAY AND last_seen > NOW() - INTERVAL $days DAY - INTERVAL $days DAY)
) * 100 AS weekly_increase
SQL
            )->fetch()[0],
            'yearlyIncrease' => $users->query()->getConnection()->execute(<<<SQL
SELECT (
	(SELECT COUNT(*) FROM users WHERE last_seen > NOW() - INTERVAL $days DAY + INTERVAL $days DAY) /
	(SELECT COUNT(*) FROM users WHERE last_seen < NOW() - INTERVAL $days DAY AND last_seen > NOW() - INTERVAL $days DAY - INTERVAL $days DAY)
) * 100 AS weekly_increase
SQL
            )->fetch()[0],
        ]);

        return null;
    }
}
