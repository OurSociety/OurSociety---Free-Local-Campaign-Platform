<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\Answer[] $answers The answers to questions.
 * @var \OurSociety\Model\Entity\Category[] $categories The question categories.
 */
?>
<ol class="breadcrumb">
    <li>Politician</li>
    <li>Dashboard</li>
</ol>

<h1>Politician Dashboard</h1>
<div class="jumbotron">
    <?= $this->Html->link(
        __('Answer More Questions!'),
        ['_name' => 'politician:questions'],
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
