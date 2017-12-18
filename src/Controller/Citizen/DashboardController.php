<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use OurSociety\Controller\AppController;
use OurSociety\Model\Questions;
use OurSociety\Model\Users;
use OurSociety\Model\ValueMatches;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardController extends AppController
{
    /**
     * @route GET /citizen
     * @routeName citizen:dashboard
     */
    public function dashboard(): ?Response
    {
        $this->set('enableVue', false);

        $this->refreshIdentity();

        $user = $this->getIdentity();

        if ($user->hasOnboarded() === false) {
            return $this->redirect(['_name' => 'users:onboarding']);
        }

        if ($user->hasAnsweredQuestions() === false) {
            $this->Flash->info(__('Please answer the following questions, then we will take you to your dashboard.'));

            return $this->redirect(['_name' => 'citizen:questions']);
        }

        // Force next level if stuck
        $levelTotal = Questions::instance()->getLevelQuestionTotal($user);
        if ($user->answer_count > $levelTotal) {
            Users::instance()->recalculateAnswerCountAndLevel($user);
            $this->refreshIdentity();
            $user = $this->getIdentity();
            $levelTotal = Questions::instance()->getLevelQuestionTotal($user);
        }

        $this->set([
            'levelQuestionTotal' => $levelTotal,
            'politicianMatch' => ValueMatches::instance()->getPoliticianMatch($user),
        ]);

        return null;
    }
}
