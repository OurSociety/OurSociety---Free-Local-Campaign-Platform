<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 */
?>

<div class="media pb-3<?= $user->is_example === true ? ' example' : '' ?>">
    <div class="d-flex mr-3 align-self-center">
        <div style="height: 100px; width: 100px;">
            <?php if ($user->picture !== null): ?>
                <div class="img-thumbnail rounded-circle">
                    <div class="circle-avatar" style="background-image: url(<?= $user->picture ?>)"></div>
                </div>
            <?php else: ?>
                <?= $this->Html->jdenticon($user->id, ['class' => ['img-thumbnail', 'rounded-circle']]) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="media-body align-self-center">
        <h5>
            <?= $user->name ?>
        </h5>
        <h6>
            <?= $user->office_type->name ?>
        </h6>
        <ul class="list-unstyled">
            <?php /*
                            <li><i class="fa fa-fw fa-home"></i> <?= sprintf('%s, %s %s', ucwords($user['location']['street']), ucwords($user['location']['city']), ucwords($user['location']['postcode'])) ?></li>
                            <li><i class="fa fa-fw fa-phone"></i> <?= $user->phone ?></li>
                            <li><i class="fa fa-fw fa-mobile-phone"></i> <?= $user['cell'] ?></li>
                            <li><i class="fa fa-fw fa-info"></i> <?= $user->areas ?></li>
                            */ ?>
            <li>
                <i class="fa fa-fw fa-envelope"></i>
                <?= $this->Html->email($user->email) ?>
            </li>
        </ul>
    </div>
</div>
