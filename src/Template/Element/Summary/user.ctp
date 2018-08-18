<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 */
?>

<div class="media pb-3<?= $user->is_example === true ? ' example' : '' ?>">
    <div class="d-flex mr-3 align-self-center">
        <div style="height: 100px; width: 100px;">
            <?= $user->renderProfilePicture($this) ?>
        </div>
    </div>
    <div class="media-body align-self-center">
        <h5>
            <?= $user->renderLink($this) ?>
        </h5>
        <h6>
            <?php
                $office = $user->getModel()
                    ->officetypes->find('list', ['conditions' => ['id' => $user->office_type_id]])
                    ->toArray();
            ?>
            <?= !empty($office) ? reset($office) : __('Unknown Office') ?>
        </h6>
        <?php if($this->request->getSession()->read('Auth')): ?>
        <?= $this->cell('Ballot/UserPoliticianMatch',
            [
                'citizen' => $this->request->getSession()->read('Auth'),
                'politician' => $user
            ])
        ?>
        <?php endif; ?>
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

