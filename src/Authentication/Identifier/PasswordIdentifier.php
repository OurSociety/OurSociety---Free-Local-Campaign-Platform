<?php
declare(strict_types=1);

namespace OurSociety\Authentication\Identifier;

use Authentication\Identifier as Authentication;
use Authentication\Identifier\IdentifierInterface;

class PasswordIdentifier implements IdentifierInterface
{
    protected $_identifier;

    public function __construct(array $config)
    {
        $this->_identifier = new Authentication\PasswordIdentifier([
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
            'resolver' => [
                'className' => Authentication\Resolver\OrmResolver::class,
                'finder' => ['auth'],
            ],
        ]);
    }

    public function identify(array $credentials)
    {
        return $this->_identifier->identify($credentials);
    }

    public function getErrors()
    {
        return $this->_identifier->getErrors();
    }
}
