<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Citizen;

use Cake\ORM\TableRegistry;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\QuestionsTable;
use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\AppController;

class DashboardController extends AppController
{
    /**
     * @route GET /citizen
     * @routeName citizen:dashboard
     */
    public function dashboard(): ?Response
    {
        /** @var User $user */
        $user = $this->Auth->user();

        if ($user->zip === null) {
            $this->Flash->success('Please provide the following information so we can find your politicians.');

            return $this->redirect(['_name' => 'users:onboarding']);
        }

        if ($user->answer_count === 0) {
            $this->Flash->success('Please answer the following questions before we take you to the dashboard.');

            return $this->redirect(['_name' => 'citizen:questions']);
        }

        $this->set([
            'levelQuestionTotal' => QuestionsTable::instance()->getLevelQuestionTotal($user),
            'politicianMatch' => TableRegistry::get('ValueMatches')->find()->contain(['Politicians'])->where([
                'citizen_id' => $this->Auth->user()->id,
                'category_id IS' => null,
            ])->first()
        ]);

        return null;
    }
}
