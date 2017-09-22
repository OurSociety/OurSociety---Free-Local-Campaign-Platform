<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\ElectoralDistrict $electoralDistrict
 */
?>

<div class="card">
    <?= $electoralDistrict->renderMap($this) ?>
    <div class="card-body">
        <h4 class="card-title">
            <?= $this->Html->link($electoralDistrict->name, $electoralDistrict->getRoute()) ?>
        </h4>
        <?php if ($electoralDistrict->hasDescription()): ?>
            <p class="card-text">
                <?= $electoralDistrict->description ?>
            </p>
        <?php endif ?>
    </div>
</div>
