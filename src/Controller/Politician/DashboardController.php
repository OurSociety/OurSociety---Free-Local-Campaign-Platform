<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use OurSociety\Controller\AppController;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardController extends AppController
{
    /**
     * @route GET /politician
     * @routeName politician:dashboard
     */
    public function dashboard(): ?Response
    {
        $this->set([
            'answers' => $this->loadModel('Answers')
                ->find()
                ->contain(['Questions'])
                ->where(['Answers.user_id' => $this->getCurrentUser()->id])
                ->orderDesc('Questions.modified')
                ->all(),
            'categories' => $this->loadModel('Categories')
                ->find()
                ->orderAsc('Categories.name')
                ->all(),
        ]);

        return null;
    }
}
