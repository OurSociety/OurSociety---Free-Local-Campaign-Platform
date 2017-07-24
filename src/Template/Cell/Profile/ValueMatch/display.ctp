<?php
/**
 * @var int $match The overall match percentage.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $similarities List of categories with match percentage.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Category[] $differences List of categories with match percentage.
 * @var \OurSociety\Model\Entity\User $politician The politician we are value matching against.
 * @var int|null $limit The limit for each list of topics.
 */
?>
<h3><?= __('{percentage}% Value Match', ['percentage' => $match]) ?></h3>
<div class="row">
    <div class="col-xs-6">
        <?= $this->cell('Profile/ValueMatch::topics', ['Similarities', $similarities]) ?>
    </div>
    <div class="col-xs-6">
        <?= $this->cell('Profile/ValueMatch::topics', ['Differences', $differences]) ?>
    </div>
    <?php if ($limit !== null): ?>
        <?= $this->Html->link(__('View all'), [
            '_name' => 'citizen:topics:compare',
            'politician' => $politician->slug,
        ], ['class' => ['btn', 'btn-primary']]) ?>
    <?php endif ?>
</div>
