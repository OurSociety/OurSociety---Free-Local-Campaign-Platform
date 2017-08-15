<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * DistrictTypes Controller
 */
class DistrictTypesController extends CrudController
{
    public function index(): ?Response
    {
        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        return $this->_form();
    }

    public function edit(): ?Response
    {
        return $this->_form();
    }

    private function _form(): ?Response
    {
        return $this->Crud->execute();
    }
}
