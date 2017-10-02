<?php
declare(strict_types=1);

namespace OurSociety\Lib\ChargeBee;

use ChargeBee_HostedPage;
use OurSociety\Model\Entity\User;

final class HostedPage
{
    /**
     * @var ChargeBee_HostedPage
     */
    private $hostedPage;

    private function __construct(ChargeBee_HostedPage $hostedPage)
    {
        $this->hostedPage = $hostedPage;
    }

    public static function createFromUserAndPlanId(User $user, string $planId): self
    {
        return new self(ChargeBee::createFromEnvironment()->createHostedPage($user, $planId));
    }

    public static function createFromId(string $id): self
    {
        return new self(ChargeBee::createFromEnvironment()->retrieveHostedPage($id));
    }

    public function getUrl(): string
    {
        return $this->hostedPage->getValues()['url'];
    }

    public function getPlanId(): ?string
    {
        /** @var \ChargeBee_Content $content */
        $content = $this->hostedPage->content();
        /** @var \ChargeBee_Subscription $subscription */
        $subscription = $content->subscription();

        return $subscription->getValues()['plan_id'] ?? null;
    }
}
