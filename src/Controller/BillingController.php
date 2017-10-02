<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use OurSociety\Lib\ChargeBee\HostedPage;
use OurSociety\Lib\ChargeBee\PortalSession;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;

class BillingController extends AppController
{
    /**
     * Billing checkout.
     *
     * Handles redirecting to ChargeBee hosted page for checking out (subscribing to a plan).
     *
     * @route GET /billing/checkout/:plan
     * @routeName billing:checkout
     * @return Response
     */
    public function checkout($planId): Response
    {
        $user = $this->getCurrentUser();
        $hostedPage = HostedPage::createFromUserAndPlanId($user, $planId);
        $redirectUrl = $hostedPage->getUrl();

        return $this->redirect($redirectUrl);
    }

    /**
     * Billing portal.
     *
     * Handles single-sign on for ChargeBee customer portal.
     *
     * @route GET /billing
     * @routeName billing
     * @return Response
     */
    public function portal(): Response
    {
        $user = $this->getCurrentUser();
        $portalSession = PortalSession::createFromUser($user);
        $redirectUrl = $portalSession->getAccessUrl();

        return $this->redirect($redirectUrl);
    }

    /**
     * Billing update.
     *
     * Handles redirects back from ChargeBee to update current plan in database.
     *
     * @route GET /billing/update
     * @routeName billing:update
     * @return Response
     */
    public function update(): Response
    {
        $state = $this->request->getQuery('state');

        switch ($state) {
            case 'success':
                $id = $this->request->getQuery('id');
                $hostedPage = HostedPage::createFromId($id);
                $planId = $hostedPage->getPlanId();
                break;
            case 'cancelled':
                $planId = null;
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown ChargeBee state "%s".', $state));
        }

        /** @var User $user */
        $user = $this->getCurrentUser();
        $user->persistPlan($planId);

        $this->Auth->refreshSession();

        return $this->redirect(['_name' => 'plans']);
    }
}
