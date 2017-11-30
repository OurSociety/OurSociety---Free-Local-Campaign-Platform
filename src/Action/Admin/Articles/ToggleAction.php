<?php
declare(strict_types=1);

namespace OurSociety\Action\Admin\Articles;

use OurSociety\Action;
use OurSociety\Model\Entity\Article;
use OurSociety\Model\Entity\ElectoralDistrict;

abstract class ToggleAction extends Action\ToggleAction
{
    protected function getRedirectUrl(string $identifier): array
    {
        /** @var Article $article */
        $article = $this->getModel()->getByUniqueIdentifier($identifier, ['Articles.electoral_district_id']);
        /** @var ElectoralDistrict $municipality */
        $municipality = $this->getModel('ElectoralDistricts')->getSlugFromId($article->electoral_district_id);

        return ['_name' => 'municipality:article', 'municipality' => $municipality, 'article' => $identifier];
    }
}
