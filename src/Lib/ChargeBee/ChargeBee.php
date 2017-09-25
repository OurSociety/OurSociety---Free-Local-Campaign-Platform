<?php
declare(strict_types=1);

namespace OurSociety\Lib\ChargeBee;

use Cake\Routing\Router;
use ChargeBee_Customer;
use ChargeBee_Environment;
use ChargeBee_HostedPage;
use ChargeBee_InvalidRequestException;
use ChargeBee_PortalSession;
use OurSociety\Model\Entity\User;

class ChargeBee
{
    private const API_ERROR_CODE_404 = 'resource_not_found';

    public static function createFromEnvironment(): self
    {
        $site = self::getEnvironmentVariable('CHARGE_BEE_SITE');
        $apiKey = self::getEnvironmentVariable('CHARGE_BEE_API_KEY');

        return new self($site, $apiKey);
    }

    private static function getEnvironmentVariable(string $name): string
    {
        $value = env($name);

        if ($value === null) {
            throw new \InvalidArgumentException("Environment variable $${name} missing.");
        }

        return $value;
    }

    private function __construct(string $site, string $apiKey)
    {
        ChargeBee_Environment::configure($site, $apiKey);
    }

    public function createHostedPage(User $user, string $planId): ChargeBee_HostedPage
    {
        $hostedPage = [
            'customer' => $this->getNewCustomerData($user),
            'subscription' => ['planId' => $planId],
            'embed' => 'false',
            'redirectUrl' => Router::url(['_name' => 'billing:update'], true),
            'cancelUrl' => Router::url(['_name' => 'plans'], true),
        ];

        return ChargeBee_HostedPage::checkoutNew($hostedPage)->hostedPage();
    }

    public function createPortalSession(User $user): ChargeBee_PortalSession
    {
        $portalSession = [
            'customer' => ['id' => $user->id],
            'redirect_url' => Router::url($user->getDashboardRoute(), true),
        ];

        try {
            return ChargeBee_PortalSession::create($portalSession)->portalSession();
        } catch (ChargeBee_InvalidRequestException $exception) {
            if ($exception->getApiErrorCode() === self::API_ERROR_CODE_404) {
                $this->insertCustomer($user);
                return ChargeBee_PortalSession::create($portalSession)->portalSession();
            }

            throw $exception;
        }
    }

    public function retrieveHostedPage(string $id): ChargeBee_HostedPage
    {
        return ChargeBee_HostedPage::retrieve($id)->hostedPage();
    }

    private function insertCustomer(User $user): ChargeBee_Customer
    {
        return ChargeBee_Customer::create($this->getNewCustomerData($user))->customer();
    }

    private function getNewCustomerData(User $user): array
    {
        return ['id' => $user->id, 'email' => $user->email];
    }
}
