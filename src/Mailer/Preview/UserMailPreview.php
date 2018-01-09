<?php
declare(strict_types=1);

namespace OurSociety\Mailer\Preview;

use DebugKit\Mailer\MailPreview;
use OurSociety\Mailer\UserMailer;
use OurSociety\Model\Entity\User;

class UserMailPreview extends MailPreview
{
    public function forgot()
    {
        return $this->getUserMailer()->forgot($this->getUser());
    }

    public function verify()
    {
        return $this->getUserMailer()->verify($this->getUser());
    }

    private function getUserMailer(): UserMailer
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getMailer('User');
    }

    private function getUser(): User
    {
        return $this->loadModel('Users')->find()->first();
    }
}
