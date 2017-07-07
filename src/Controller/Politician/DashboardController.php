<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Politician;

use Cake\Http\Response;
use OurSociety\Controller\AppController;

class DashboardController extends AppController
{
    /**
     * @route GET /politician
     * @routeName politician:dashboard
     */
    public function index(): ?Response
    {
        return null; // TODO: Set some view variables.
    }
}
