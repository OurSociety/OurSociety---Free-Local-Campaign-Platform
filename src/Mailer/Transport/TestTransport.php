<?php
declare(strict_types = 1);

namespace OurSociety\Mailer\Transport;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Mailer\Transport\DebugTransport;

class TestTransport extends DebugTransport
{
    /**
     * {@inheritdoc}
     */
    public function send(Email $email): array
    {
        $parts = parent::send($email);

        Configure::write('EmailTransport.test', $parts);

        return $parts;
    }
}
