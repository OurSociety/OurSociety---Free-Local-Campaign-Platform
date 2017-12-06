<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user.
 */

$this->Breadcrumbs->add(__('Dashboard'), $user->getDashboardRoute());
$this->Breadcrumbs->add(__('Profile'), $user->getProfileRoute());

$actions = [
    __('Edit details') => ['_name' => 'users:edit'],
    __('Change password') => ['_name' => 'users:reset'],
    __('Change municipality') => ['_name' => 'users:onboarding', '?' => ['screen' => 'location']],
];
?>

<h2>
    <?= $user->name ?>
</h2>

<hr>

<div class="media">
    <div class="media-left">
        <?= $user->renderProfilePicture($this, [
            'class' => ['img-thumbnail', 'mr-3'],
            'style' => 'max-width: 100px',
        ]) ?>
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

<?php foreach ($actions as $title => $url): ?>
    <?= $this->Html->button($title, $url, ['size' => 'sm', 'class' => ['mr-3']]) ?>
<?php endforeach ?>
