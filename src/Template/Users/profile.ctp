<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user.
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Account profile'), ['_name' => 'users:profile']) ?></li>
    <li><?= $user->name ?></li>
</ol>

<h2>Profile</h2>

<hr>

<div class="media">
    <div class="media-left">
        <?= $this->Html->image($user->picture) ?>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= $user->name ?></h4>
        <dl>
            <dt>Phone number</dt>
            <dd><?= $user->phone ?? $this->Html->tag('span', '&mdash;', ['class' => 'text-muted']) ?></dd>
            <dt>Email</dt>
            <dd><?= $this->Html->link($user->email, 'mailto:' . $user->email) ?></dd>
            <dt>Member since</dt>
            <dd><abbr title="<?= $user->created ?>"><?= $user->created->timeAgoInWords() ?></abbr></dd>
        </dl>
    </div>
</div>

<?= $this->Html->link(__('Edit details'), ['_name' => 'users:edit'], ['class' => 'btn btn-sm btn-default']) ?>
<?= $this->Html->link(__('Change password'), ['_name' => 'users:reset'], ['class' => 'btn btn-sm btn-default']) ?>
