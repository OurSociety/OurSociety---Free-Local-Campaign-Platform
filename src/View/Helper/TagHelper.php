<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use Cake\View\Helper;
use OurSociety\View\Tag;

class TagHelper extends Helper
{
    public function render(Tag\Tag $tag): string
    {
        return $this->getView()->element($tag->getElementName(), ['tag' => $tag]);
    }
}
