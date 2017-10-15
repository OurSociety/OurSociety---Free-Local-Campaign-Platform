<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Psr\Http\Message\ResponseInterface as Response;

class PlansController extends AppController
{
    public function index(): ?Response
    {
        $this->set('containerClass', 'container-fluid');

        return null;
    }
}
