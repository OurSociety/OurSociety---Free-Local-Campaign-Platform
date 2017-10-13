<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The currently logged in user.
 * @var \OurSociety\Model\Entity\Article $article The currently viewed article.
 */

$this->extend('/Common/Articles/view');

$this->Breadcrumbs->add(__('Dashboard'), $currentUser->getDashboardRoute());
$this->Breadcrumbs->add(__('Profile'), $currentUser->getProfileRoute());
$this->Breadcrumbs->add($article->name);

$this->start('actions');
?>
    <?= $article->renderPoliticianEditButton($this) ?>
<?php
$this->end();
