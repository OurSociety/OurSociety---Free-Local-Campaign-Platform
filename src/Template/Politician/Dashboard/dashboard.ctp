<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $identity
 * @var \OurSociety\Model\Entity\Answer[] $answers The answers to questions.
 * @var \OurSociety\Model\Entity\CategoriesUser[] $categories The question categories.
 * @var int $questionCount The number of questions.
 */

$this->Breadcrumbs->add(__('My Dashboard'))
?>

<div class="row">
    <div class="col">
        <h2>
            <?= __('My Dashboard') ?>
        </h2>
    </div>
    <div class="col-auto text-center">
        <div class="btn-group">
            <?= $this->Html->link(
                __('My Profile'),
                ['_name' => 'politician:profile'],
                ['class' => 'btn btn-secondary']
            ) ?>
            <?= $this->Html->link(
                __('My Municipality'),
                ['_name' => 'municipality:default'],
                ['class' => 'btn btn-info']
            ) ?>
        </div>
    </div>
</div>

<hr>

<?= $this->element('Widgets/Dashboard/Politician/values', ['questionCount' => $questionCount]) ?>

<section class="row">

    <div class="col-md-6">
        <div class="card card-default">
            <h4 class="card-header">
                <?= __('Questions answered') ?>
            </h4>
            <table class="table table-bordered table-striped table-sm" style="table-layout: fixed">
                <thead>
                <tr>
                    <th>
                        <?= __('Question') ?>
                    </th>
                    <th style="width: 30%">
                        <?= __('Your answer') ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($answers as $answer): ?>
                    <tr>
                        <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?= $answer->question->question ?>
                        </td>
                        <td>
                            <?= $answer->name ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-default">
            <h4 class="card-header">
                <?= __('Progress by category') ?>
            </h4>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>
                        <?= __('Category') ?>
                    </th>
                    <th>
                        <?= __('Questions answered') ?>
                    </th>
                    <th>
                        <?= __('Question total') ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <?= $category->category->name ?>
                        </td>
                        <td>
                            <?= $category->answer_count ?>
                        </td>
                        <td>
                            <?= $category->category->question_count ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
