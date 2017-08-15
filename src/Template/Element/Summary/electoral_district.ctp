<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\ElectoralDistrict $electoralDistrict
 * @var array|string|null $url
 */
?>

<?= $electoralDistrict->renderLink($this, $url ?? null) ?>
<?php if ($electoralDistrict->district_type): ?>
    &ndash; <?= $electoralDistrict->district_type->name ?>
<?php endif ?>
