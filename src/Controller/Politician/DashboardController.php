<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use OurSociety\Controller\AppController;
use OurSociety\Model\Questions;
use OurSociety\Model\Users;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardController extends AppController
{
    /**
     * @route GET /politician
     * @routeName politician:dashboard
     */
    public function dashboard(): ?Response
    {
        $user = $this->getIdentity();

        if (!$user->hasOnboarded()) {
            return $this->redirect(['_name' => 'users:onboarding']);
        }

        $this->set([
            'questionCount' => Questions::instance()->getCount(),
            'answers' => Users::instance()->getAnswers($user),
            'categories' => Users::instance()->getCategoriesForPoliticianDashboard($user),
        ]);

        return null;
    }
}
