<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $currentUser
 * @var \OurSociety\Model\Entity\Report $report
 * @var \OurSociety\Model\Entity\Question $question
 */
?>

<h2><?= __('Report Question') ?></h2>

<div class="row">
    <div class="col-md-6 pb-3 order-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <?= __('Question') ?>
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-auto order-sm-12 text-center">
                        <?= $this->Html->icon(
                            $question->category->slug,
                            ['iconSet' => 'topic', 'height' => 100, 'width' => 100]
                        ) ?>
                    </div>
                    <div class="col-sm">
                        <blockquote class="blockquote">
                            <p><?= $question->question ?></p>
                            <footer class="blockquote-footer">
                                <?= __('Category') ?>:
                                <cite>
                                    <?= $question->category->name ?>
                                </cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 pb-3 order-md-1">
        <?= $this->Form->create($report) ?>
        <?= $this->Form->control('question_id', ['type' => 'hidden', 'value' => $question->id]) ?>
        <?= $this->Form->control('user_id', ['type' => 'hidden', 'value' => $currentUser->id]) ?>
        <?= $this->Form->control('body', ['label' => false, 'placeholder' => __('Let us know why you are reporting this question.')]) ?>
        <?= $this->Form->button(__('Report Question'), ['class' => ['btn-lg', 'btn-secondary', 'btn-block']]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
