<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser The currently logged in user.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Article[] $articles The articles.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */

$this->set('title', sprintf('%s Articles', $municipality->name));

if ($currentUser && $currentUser->isInMunicipality($municipality)) {
    $this->Breadcrumbs->add(__('My Municipality'), $municipality->getRoute());
} else {
    $this->Breadcrumbs->add(__('Municipalities'), $municipality->getBrowseRoute());
    $this->Breadcrumbs->add($municipality->name, $municipality->getRoute());
}
$this->Breadcrumbs->add(__('Articles'));
?>

<h1>
    <?= __('Articles') ?>
    <small class="text-muted">
        <?= __('Policies, Plans & Visions') ?>
    </small>
</h1>

<p>Choose one of the articles below to start reading.</p>

<?php foreach ($articles as $article): ?>
    <?= $article->renderSummaryElement($this) ?>
<?php endforeach ?>
