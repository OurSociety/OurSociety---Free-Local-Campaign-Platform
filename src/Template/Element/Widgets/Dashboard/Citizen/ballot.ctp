<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 */
?>
<div class="card mb-3">
    <h4 class="card-header">
        <?= __('My Virtual Ballot') ?>
    </h4>
    <div class="card-body">
        <?php if ($identity->electoral_district === null): ?>
            <p>
                <?= __('By selecting your electoral district, we can show you your virtual ballot!') ?>
            </p>

            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Html->link(
                        __('Select electoral district'),
                        ['_name' => 'users:onboarding'],
                        ['class' => ['btn', 'btn-primary', 'btn-block']]
                    ) ?>
                </div>
            </div>
        <?php else: ?>
            <p>
                <?= __('You have indicated you are in the municipality of {municipality}.', [
                    'municipality' => $this->Html->link($identity->electoral_district->name, [
                        '_name' => 'district',
                        $identity->electoral_district->slug,
                    ]),
                ]) ?>
            </p>
            <p>
                <?= __('From this, we can work out who you should be voting for in the upcoming New Jersey gubernatorial election, 2017!') ?>
            </p>

            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Html->link(
                        __("Let's see my virtual ballot"),
                        ['_name' => 'citizen:ballots'],
                        ['class' => ['btn', 'btn-primary', 'btn-block']]
                    ) ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
