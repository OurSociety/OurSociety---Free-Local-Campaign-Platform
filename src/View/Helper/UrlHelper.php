<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use Cake\View\Helper as Cake;
use Gravatar\Gravatar;

class UrlHelper extends Cake\UrlHelper
{
    public function gravatarUrl(string $email, ?array $defaults = []): string
    {
        $gravatar = new Gravatar(['d' => 'identicon', 's' => 500] + $defaults, true);

        return $gravatar->avatar($email);
    }
}
