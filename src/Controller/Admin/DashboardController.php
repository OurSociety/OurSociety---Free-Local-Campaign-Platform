<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

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
    public function index(): ?Response
    {
        $users = $this->loadModel('Users');

        $this->set([
            'recentlyCreatedUsers' => $users->find('recentlyCreated'),
            'recentlyActiveUsers' => $users->find('recentlyActive'),
        ]);

        return null;
    }
}
