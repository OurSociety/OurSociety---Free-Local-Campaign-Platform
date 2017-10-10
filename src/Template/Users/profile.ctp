<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user.
 */

$user = \OurSociety\ORM\TableRegistry::get('Users')->get('fadbd13b-35d1-4b62-82e7-f60ee2709467');
$this->Breadcrumbs->add(__('Dashboard'), $user->getDashboardRoute());
$this->Breadcrumbs->add(__('Profile'), $user->getProfileRoute());
?>

<h2><?= $user->name ?></h2>

<hr>

<div class="media">
    <div class="media-left">
        <?= $user->renderProfilePicture($this, ['class' => 'img-thumbnail mr-3', 'style' => 'max-width: 100px']) ?>
    </div>
    <div class="media-body">
        <dl>
            <dt><?= __('Phone number') ?></dt>
            <dd><?= $user->phone ?? $this->Html->tag('span', '&mdash;', ['class' => 'text-muted']) ?></dd>
            <dt><?= __('Email') ?></dt>
            <dd><?= $user->renderEmailLink($this) ?></dd>
            <dt><?= __('Member since') ?></dt>
            <dd><abbr title="<?= $user->created ?>"><?= $user->created->timeAgoInWords() ?></abbr></dd>
        </dl>
    </div>
</div>

<?= $this->Html->link(__('Edit details'), ['_name' => 'users:edit'], ['class' => 'btn btn-sm btn-primary mr-3']) ?>
<?= $this->Html->link(__('Change password'), ['_name' => 'users:reset'], ['class' => 'btn btn-sm btn-primary mr-3']) ?>
