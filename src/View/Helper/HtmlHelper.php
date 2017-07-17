<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use Gravatar\Gravatar;

class HtmlHelper extends BootstrapUI\HtmlHelper
{
    public function gravatar(string $email, ?array $options = []): string
    {
        $gravatar = new Gravatar([], true);
        $path = $gravatar->avatar($email);

        return $this->image($path, $options + ['class' => 'img-circle']);
    }
}
