<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User|null $currentUser The currently logged in user, if any.
 * @var int $match The overall match percentage.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $similarities List of categories with match percentage.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $differences List of categories with match percentage.
 * @var \OurSociety\Model\Entity\User $politician The politician we are value matching against.
 * @var int|null $limit The limit for each list of topics.
 */

$watermark = $currentUser !== null && !$currentUser->isCitizen();
?>
<?php if ($watermark === true): ?>
<div style="display: flex;">
    <div class="watermark" data-watermark="Example Match" style="align-items: stretch; width: 100%">
        <?php endif ?>

        <h3><?= __('{percentage}% Value Match', ['percentage' => $match]) ?></h3>

        <div class="row text-left">
            <div class="col-xs-offset-1 col-xs-5">
                <?= $this->cell('Profile/ValueMatch::topics', ['Similarities', $similarities]) ?>
            </div>
            <div class="col-xs-offset-1 col-xs-5">
                <?= $this->cell('Profile/ValueMatch::topics', ['Differences', $differences]) ?>
            </div>
        </div>

        <div class="row">
            <?php if ($watermark): ?>
                <?= $this->Html->link(__('Learn More'), '#', ['class' => ['btn', 'btn-primary', 'disabled']]) ?>
            <?php elseif ($limit !== null): ?>
                <?= $this->Html->link(__('View More'), [
                    '_name' => 'citizen:topics:compare',
                    'politician' => $politician->slug,
                ], ['class' => ['btn', 'btn-primary']]) ?>
            <?php endif ?>
        </div>

        <?php if ($watermark === true): ?>
    </div>
</div>
<?php endif ?>
