<?php
declare(strict_types=1);

namespace OurSociety\Auth;

use Xety\Cake3CookieAuth\Auth as CookieAuth;

/**
 * Authentication adapter for "remember me" functionality.
 *
 * Logs the user in if a "remember_me" cookie is present on their machine.
 */
class CookieAuthenticate extends CookieAuth\CookieAuthenticate
{
    /**
     * {@inheritdoc}
     *
     * Copied from CakePHP core with one difference - it returns a User entity instead of an array on the last line.
     */
    protected function _findUser($username, $password = null)
    {
        $result = $this->_query($username)->first();

        if (empty($result)) {
            return false;
        }

        $passwordField = $this->_config['fields']['password'];
        if ($password !== null) {
            $hasher = $this->passwordHasher();
            $hashedPassword = $result->get($passwordField);
            if (!$hasher->check($password, $hashedPassword)) {
                return false;
            }

            $this->_needsPasswordRehash = $hasher->needsRehash($hashedPassword);
            $result->unsetProperty($passwordField);
        }
        $hidden = $result->getHidden();
        if ($password === null && in_array($passwordField, $hidden, true)) {
            $key = array_search($passwordField, $hidden, true);
            unset($hidden[$key]);
            $result->setHidden($hidden);
        }

        return $result;
    }
}
