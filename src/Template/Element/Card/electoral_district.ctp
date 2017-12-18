<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\ElectoralDistrict $electoralDistrict
 */
?>

<div class="card">
    <?= $electoralDistrict->renderMap($this) ?>
    <div class="card-body">
        <h4 class="card-title mb-0">
            <?= $electoralDistrict->renderLink($this) ?>
        </h4>
        <?php if ($electoralDistrict->hasDescription()): ?>
            <p class="card-text">
                <?= $electoralDistrict->description ?>
            </p>
        <?php endif ?>
    </div>
</div>
