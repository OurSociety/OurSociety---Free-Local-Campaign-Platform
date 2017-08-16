<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User[] $recentlyActiveUsers The recently active users.
 * @var \OurSociety\Model\Entity\User[] $recentlyCreatedUsers The recently created users.
 */
$defaultRange = 'week';
$ranges = [
    $defaultRange => __('Weekly'),
    'month' => __('Monthly'),
    'year' => __('Yearly'),
];

$this->set('title', 'Users Dashboard');
?>

<?php $this->start('breadcrumb-actions') ?>
<div class="btn-group" role="group" aria-label="Basic example">
    <?php foreach ($ranges as $name => $label): ?>
        <?php
        $options = ['class' => ['btn', 'btn-light'], 'role' => 'button'];
        if ($this->request->getQuery('range') === $name):
            $options['class'][] = 'active';
            $options['aria-pressed'] = true;
        endif;
        ?>
        <?= $this->Html->link($label, ['?' => ['range' => $name]], $options) ?>
    <?php endforeach ?>
</div>

<!--
<?= $this->Form->create(null, ['type' => 'GET', 'class' => 'form-inline']) ?>
<?= $this->Form->control('range', [
    'class' => ['form-control-sm'],
    'default' => $this->request->getQuery('range', $defaultRange),
    'label' => false,
    'onchange' => 'this.form.submit()',
    'options' => $ranges,
]) ?>
<?= $this->Form->end() ?>
-->
<?php $this->end() ?>

<?php
/**
 * Numbers
 */
?>
<?php
$numbers = [
    ['name' => 'users_created', 'label' => 'New Users', 'style' => 'pink', 'icon' => 'user-plus'],
    ['name' => 'citizens_created', 'label' => 'New Citizens', 'style' => 'green', 'icon' => 'user-plus'],
    ['name' => 'politicians_created', 'label' => 'New Politicians', 'style' => 'blue', 'icon' => 'user-plus'],
    ['name' => 'users_seen', 'label' => 'Active Users', 'style' => 'pink', 'icon' => 'sign-in'],
    ['name' => 'citizens_seen', 'label' => 'Active Citizens', 'style' => 'green', 'icon' => 'sign-in'],
    ['name' => 'politicians_seen', 'label' => 'Active Politicians', 'style' => 'blue', 'icon' => 'sign-in'],
];
?>
<div class="row pb-3">
    <?php foreach ($numbers as $number): ?>
        <div class="col-6 col-sm-4 col-xl-2">
            <?= $this->cell(
                'Dashboard/NumberWidget',
                [],
                ['period' => $this->request->getQuery('range', 'week')] + $number
            ) ?>
        </div>
    <?php endforeach ?>
</div>

<?php
/**
 * Charts
 */
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<div class="row pb-3">
    <div class="col">
        <?= $this->element('Dashboard/Chart/user_role') ?>
    </div>
    <div class="col">
        <?= $this->element('Dashboard/Chart/user_cohort') ?>
    </div>
</div>

<section class="row">
    <div class="col-md-6">
        <div class="card card-default">
            <h4 class="card-header">
                <?= $this->Html->link(
                    __('Recently Created Users'),
                    ['action' => 'index', '?' => ['sort' => 'created', 'direction' => 'desc']]
                ) ?>
            </h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Registered</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($recentlyCreatedUsers as $user): ?>
                    <tr>
                        <td><?= $this->Html->link(
                                $user->name,
                                ['controller' => 'Users', 'action' => 'view', $user->id]
                            ) ?></td>
                        <td><?= ucfirst($user->role) ?></td>
                        <td><?= $this->Time->timeAgoInWords($user->created) ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-default">
            <h4 class="card-header">
                <?= $this->Html->link(
                    __('Recently Active Users'),
                    ['action' => 'index', '?' => ['sort' => 'last_seen', 'direction' => 'desc']]
                ) ?>
            </h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Last Seen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($recentlyActiveUsers as $user): ?>
                    <tr>
                        <td><?= $this->Html->link(
                                $user->name,
                                ['controller' => 'Users', 'action' => 'view', $user->id]
                            ) ?></td>
                        <td><?= ucfirst($user->role) ?></td>
                        <td><?= $this->Time->timeAgoInWords($user->last_seen) ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
