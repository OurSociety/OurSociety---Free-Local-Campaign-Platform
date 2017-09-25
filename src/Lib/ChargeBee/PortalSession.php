<?php
declare(strict_types=1);

namespace OurSociety\Lib\ChargeBee;

use ChargeBee_PortalSession;
use OurSociety\Model\Entity\User;

final class PortalSession
{
    /**
     * @var ChargeBee_PortalSession
     */
    private $portalSession;

    private function __construct(ChargeBee_PortalSession $portalSession)
    {
        $this->portalSession = $portalSession;
    }

    public static function createFromUser(User $user): self
    {
        return new self(ChargeBee::createFromEnvironment()->createPortalSession($user));
    }

    public function getAccessUrl(): string
    {
        return $this->portalSession->getValues()['access_url'];
    }
}
