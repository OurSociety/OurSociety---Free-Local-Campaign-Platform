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
    public function index(): ?Response
    {
        if ($this->Auth->user('answer_count') === 0) {
            $this->Flash->success('Please answer the following questions before we take you to the dashboard.');

            return $this->redirect(['_name' => 'politician:questions']);
        }

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
