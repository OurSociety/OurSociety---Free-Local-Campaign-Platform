<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The currently logged in user.
 * @var \OurSociety\Model\Entity\Article $article The currently viewed article.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The currently viewed municipality.
 */

$this->extend('/Common/Articles/view');

if ($currentUser->isInMunicipality($municipality)) {
    $this->Breadcrumbs->add(__('My Municipality'), $municipality->getRoute());
} else {
    $this->Breadcrumbs->add(__('Municipalities'), $municipality->getBrowseRoute());
    $this->Breadcrumbs->add($municipality->name, $municipality->getRoute());
}
$this->Breadcrumbs->add(__('Articles'), $municipality->getArticlesRoute());
$this->Breadcrumbs->add($article->name);
