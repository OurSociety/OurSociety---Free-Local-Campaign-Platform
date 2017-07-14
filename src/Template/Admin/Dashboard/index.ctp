<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User[] $recentlyActiveUsers The recently active users.
 * @var \OurSociety\Model\Entity\User[] $recentlyCreatedUsers The recently created users.
 */
?>
<ol class="breadcrumb">
    <li>Admin</li>
    <li>Dashboard</li>
</ol>

<h1>Admin Dashboard</h1>

<?= $this->Html->link('Questions', ['_name' => 'admin:questions'], ['class' => 'btn btn-default']) /* TODO: Move to navbar */ ?>

<section class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Recently Created Users') ?></h3>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Registered</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($recentlyCreatedUsers as $user): ?>
                    <tr>
                        <td><?= ucfirst($user->role) ?></td>
                        <td><?= $this->Html->link(
                                $user->name,
                                ['controller' => 'Users', 'action' => 'view', $user->id]
                            ) ?></td>
                        <td><?= $this->Time->timeAgoInWords($user->created) ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Recently Active Users') ?></h3>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Last Seen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($recentlyActiveUsers as $user): ?>
                    <tr>
                        <td><?= ucfirst($user->role) ?></td>
                        <td><?= $this->Html->link(
                                $user->name,
                                ['controller' => 'Users', 'action' => 'view', $user->id]
                            ) ?></td>
                        <td><?= $this->Time->timeAgoInWords($user->created) ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
