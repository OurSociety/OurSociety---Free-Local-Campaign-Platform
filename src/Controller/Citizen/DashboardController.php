<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Citizen;

use OurSociety\Model\Table\QuestionsTable;
use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\AppController;

class DashboardController extends AppController
{
    /**
     * @route GET /citizen
     * @routeName citizen:dashboard
     */
    public function index(): ?Response
    {
        /** @var QuestionsTable $questions */
        $questions = $this->loadModel('Questions');

        $this->set([
            'questions' => $questions->findBatch(),
        ]);

        return null;
    }
}
