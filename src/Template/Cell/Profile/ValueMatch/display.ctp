<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var int $match The overall match percentage.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $similarities List of categories with match percentage.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $differences List of categories with match percentage.
 * @var \OurSociety\Model\Entity\User $politician The politician we are value matching against.
 * @var int|null $limit The limit for each list of topics.
 * @var bool $isExample True if displayed as example.
 */
?>
<?php if ($isExample === true): ?>
<div class="example" style="display: flex;">
    <div class="watermark" data-watermark="Example Match" style="align-items: stretch; width: 100%">
        <?php endif ?>

        <h3><?= __('{percentage}% Value Match', ['percentage' => $match]) ?></h3>

        <div class="row text-left">
            <div class="col-auto mx-auto">
                <?= $this->cell('Profile/ValueMatch::topics', ['Most Similar', $similarities]) ?>
            </div>
            <div class="col-auto mx-auto">
                <?= $this->cell('Profile/ValueMatch::topics', ['Least Similar', $differences]) ?>
            </div>
        </div>

        <?php if ($isExample === true): ?>
    </div>
</div>
<?php endif ?>

<div class="row">
    <div class="col-auto mx-auto">
        <?php if ($isExample === false && $limit !== null): ?>
            <?= $this->Html->link(
                __('View All'),
                ['_name' => 'citizen:topics:compare', 'politician' => $politician->slug],
                ['class' => ['btn', 'btn-primary']]
            ) ?>
        <?php endif ?>
        <?= $this->Html->link(
            __('Learn More'),
            ['_name' => 'guide:matching'],
            ['class' => ['btn', 'btn-warning']]
        ) ?>
    </div>
</div>
