<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $currentUser
 * @var \OurSociety\Model\Entity\Answer[] $answers The answers to questions.
 * @var \OurSociety\Model\Entity\Category[] $categories The question categories.
 */
?>
<ol class="breadcrumb">
    <li>Politician</li>
    <li>Dashboard</li>
</ol>

<?= $this->Html->link(__('View Profile'), ['_name' => 'politician:profile'], ['class' => ['btn btn-default pull-right']]) ?>

<h2>Politician Dashboard</h2>

<hr>

<div class="jumbotron">
    <?= $this->Html->link(
        __('Answer Questions'),
        ['_name' => 'politician:questions'],
        ['class' => ['btn', 'btn-primary', $currentUser->answer_count === 50 ? 'disabled' : '']]
    ) ?>
    <?= $this->Html->link(
        __('Politician Profile'),
        ['_name' => 'politician:profile'],
        ['class' => 'btn btn-primary']
    ) ?>
    <?= $this->Html->link(
        __('Municipal Profile'),
        ['_name' => 'municipality:default'],
        ['class' => 'btn btn-primary']
    ) ?>
</div>

<section class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Questions answered') ?></h3>
            </div>
            <table class="table table-bordered table-striped table-sm" style="table-layout: fixed">
                <thead>
                <tr>
                    <th>Question</th>
                    <th style="width: 30%">Your answer</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($answers as $answer): ?>
                    <tr>
                        <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $answer->question->question ?></td>
                        <td><?= $answer->name ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Progress by category') ?></h3>
            </div>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Questions answered</th>
                    <th>Question total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category->name ?></td>
                        <td>0</td>
                        <td><?= $category->question_count ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
