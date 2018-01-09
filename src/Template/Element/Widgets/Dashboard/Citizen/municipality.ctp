<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 */
?>
<div class="card mb-3">
    <h4 class="card-header">
        <?= __('My Municipality') ?>
    </h4>
    <div class="card-body">
        <?php if ($identity->electoral_district === null): ?>
            <p>
                <?= __('By selecting your electoral district, we can show you your municipality profile!') ?>
            </p>

            <div class="row">
                <div class="col"></div>
                <div class="col-md-6 col-lg-4">
                    <?= $this->Html->link(
                        __('Select electoral district'),
                        ['_name' => 'users:onboarding'],
                        ['class' => ['btn', 'btn-primary', 'btn-block']]
                    ) ?>
                </div>
            </div>
        <?php else: ?>
            <?= $this->element('Widgets/MunicipalProfile/stats', ['municipality' => $identity->electoral_district]) ?>

            <div class="row mt-3">
                <div class="col"></div>
                <div class="col-md-6 col-lg-4">
                    <?= $this->Html->link(
                        __('Go to municipal profile'),
                        ['_name' => 'municipality:default'],
                        ['class' => ['btn', 'btn-primary', 'btn-block']]
                    ) ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
