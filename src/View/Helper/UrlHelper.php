<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use Cake\View\Helper as Cake;
use OurSociety\Model\Entity\User;

class UrlHelper extends Cake\UrlHelper
{
    public function image($path, array $options = []): string
    {
        if ($path instanceof User) {
            return $this->profilePicture($path, $options);
        }

        return parent::image($path, $options);
    }

    public function profilePicture(User $user, array $options = null): string
    {
        $options = $options ?? [];

        $path = $user->picture;
        $options += ['pathPrefix' => sprintf('upload/profile/picture/%s/', $user->id)];

        return $this->assetUrl($path, $options);
    }
}
