<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $user
 */
use OurSociety\Model\Entity\User;

/**
 * @var User $user The user.
 */
?>
<h1>Profile</h1>
<h2><?= $user->name ?></h2>
<dl>
    <dt>Email</dt>
    <dd><?= $user->email ?></dd>
</dl>
<?= $this->Html->link(__('Change password'), ['_name' => 'users:reset'], ['class' => 'btn btn-sm btn-default']) ?>
