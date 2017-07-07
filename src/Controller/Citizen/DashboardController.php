<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Citizen;

use Cake\Http\Response;
use OurSociety\Controller\AppController;

class DashboardController extends AppController
{
    /**
     * @route GET /citizen
     * @routeName citizen:dashboard
     */
    public function index(): ?Response
    {
        return null; // TODO: Set some view variables.
    }
}
