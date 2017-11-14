<?php
declare(strict_types=1);

namespace OurSociety\Http\Cookie;

use Cake\Http\Cookie\Cookie;
use Cake\I18n\FrozenTime;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\TokensTable;
use OurSociety\ORM\TableRegistry;

class AuthenticationTokenCookie extends Cookie
{
    public function __construct(User $user)
    {
        /** @var TokensTable $tokensTable */
        $tokensTable = TableRegistry::get('Tokens');
        $token = $tokensTable->createToken($user);

        $value = $token->toArray();
        $expiresAt = FrozenTime::now()->addYear();
        $path = $request->getAttribute('webroot');
        $domain = '';
        $secure = true;
        $httpOnly = true;

        dd($name, $value, $expiresAt, $path, $domain, $secure, $httpOnly);
        parent::__construct($name, $value, $expiresAt, $path, $domain, $secure, $httpOnly);
    }

    //public static function fromServerRequest(ServerRequestInterface $request): self
    //{
    //    $name = 'remember_me';
    //    $requestData = $request->getParsedBody();
    //    $value = ['email' => $requestData['email'], 'password' => $requestData['password']];
    //    $expiresAt = FrozenTime::now()->addYear();
    //
    //    return new self($name, $value, $expiresAt, $request->getAttribute('webroot'), 'oursociety.dev', true, true);
    //}
}
