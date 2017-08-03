<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Politician;

use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\AppController;

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
                ->where(['Answers.user_id' => $this->Auth->user('id')])
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
