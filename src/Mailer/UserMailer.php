<?php
declare(strict_types=1);

namespace OurSociety\Mailer;

use Cake\Mailer\Mailer;
use OurSociety\Model\Entity\User;

class UserMailer extends Mailer
{
    public function forgot(User $user): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->setTo($user->email)
            ->setSubject('Forgot password')
            ->set([
                'name' => $user->name,
                'token' => $user->token,
                'url' => [
                    '_full' => true,
                    '_name' => 'users:reset',
                    '?' => [
                        'email' => $user->email,
                        'token' => $user->token,
                    ],
                ],
            ]);
    }

    public function verify(User $user): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->setTo($user->email)
            ->setSubject(sprintf('Welcome %s', $user->name))
            ->set([
                'name' => $user->name,
                'token' => $user->token,
                'url' => [
                    '_full' => true,
                    '_name' => 'users:verify',
                    '?' => [
                        'token' => $user->token,
                    ],
                ],
            ]);
    }
}
