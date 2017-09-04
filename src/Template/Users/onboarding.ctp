<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 * @var \OurSociety\Model\Entity\User|null $currentUser The current user.
 */
?>

<div class="row">
    <div class="col-md-6" style="padding: 5rem; background-color: #eee; min-height: 750px;">
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="tutorial-1">
                <p style="font-size: 36px;">
                    <?= __('First, we give you a question about your values.') ?>
                </p>

                <article class="panel panel-default js-question">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= __('Question #{number}', ['number' => 1]) ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row row-md-flex-center">
                            <div class="col-md-12">
                                <blockquote>
                                    <?= $this->Html->icon('law', ['iconSet' => 'topic', 'height' => 100, 'width' => 100]) ?>
                                    <p>
                                        <?= __(implode(' ', [
                                            "Contracts to obtain, retain, profit from, manage, or dispose of one's",
                                            'private property should be regulated by the government.'
                                        ])) ?>
                                    </p>
                                    <footer><?= __('Category') ?>: <cite><?= __('Law') ?></cite></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="nav">
                    <a href="#tutorial-2" aria-controls="tutorial-2" role="tab" data-toggle="tab" class="btn btn-default">
                        <?= __('Continue') ?>
                    </a>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tutorial-2">
                <p style="font-size: 36px;">
                    <?= __('Then, you choose whether you agree or disagree.') ?>
                </p>

                <article class="panel panel-default js-question">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= __('Question #{number}', ['number' => 1]) ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row row-md-flex-center">
                            <div class="col-md-12 form-question-answers">
                                <?= $this->Form->control('answer', [
                                    'required' => false,
                                    'label' => false,
                                    'type' => 'radio',
                                    'options' => OurSociety\Model\Entity\Answer::ANSWERS_SCALE,
                                    'disabled' => true,
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="nav">
                    <a href="#tutorial-3" aria-controls="tutorial-3" role="tab" data-toggle="tab" class="btn btn-default">
                        <?= __('Continue') ?>
                    </a>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tutorial-3">
                <p style="font-size: 36px;">
                    <?= __('Finally, you tell us how important this topic is to you.') ?>
                </p>

                <article class="panel panel-default js-question">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= __('Question #{number}', ['number' => 1]) ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row row-md-flex-center">
                            <div class="col-md-12 form-question-importance">
                                <?= $this->Form->control('importance', [
                                    'inline' => true,
                                    'required' => false,
                                    'label' => false,
                                    'type' => 'radio',
                                    'class' => ['has-error'],
                                    'options' => OurSociety\Model\Entity\Answer::IMPORTANCE,
                                    'disabled' => true,
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="nav">
                    <a href="#tutorial-4" aria-controls="tutorial-4" role="tab" data-toggle="tab" class="btn btn-default">
                        <?= __('Continue') ?>
                    </a>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tutorial-4">
                <p style="font-size: 36px;">
                    <?= __('If you are unsure, you can always choose to answer later.') ?>
                </p>

                <article class="panel panel-default js-question">
                    <div class="panel-heading">
                        <div class="pull-right small text-muted">
                            Not sure?
                            <?= $this->Html->link(__('Answer Later'), '#question-1', [
                                'aria-controls' => '#question-1',
                                'class' => ['js-question-link', 'text-info'],
                                'data-toggle' => 'collapse',
                            ]) ?>
                        </div>
                        <h3 class="panel-title"><?= __('Question #{number}', ['number' => 1]) ?></h3>
                    </div>
                </article>

                <div class="nav">
                    <a href="#location" aria-controls="location" role="tab" data-toggle="tab" class="btn btn-default">
                        <?= __('Continue') ?>
                    </a>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="location">
                <p style="font-size: 36px;">
                    <?= __('Please select your location to continue!') ?>
                </p>

                <p>
                    <?= __('By selecting your location we can match you to {role} in your area.', [
                        'role' => $currentUser->isPolitician() ? __('constituents') : __('politicians')
                    ]) ?>
                </p>

                <?= $this->Form->create($user) ?>
                <?= $this->Form->control('electoral_district_id', [
                    'aria-autocomplete' => 'both',
                    'class' => ['js-autocomplete'],
                    'data-filter-field' => 'name',
                    'data-url' => $this->Url->build(['_name' => 'district:lookup']),
                    'empty' => true,
                    'required' => true,
                    'label' => false,
                    'placeholder' => __('Select your municipality'),
                ]) ?>
                <!--
                <?= $this->Form->control('zip', [
                    'type' => 'text',
                    'required' => true,
                    'label' => __('ZIP code')
                ]) ?>
                -->
                <?= $this->Form->button(__('Save')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="padding: 5rem; background-color: #852c92; color: white; min-height: 750px;">
        <h1 style="font-weight: 900; font-size: 48px; margin: 0 0 1em 0;">
            <?= __('Congratulations!') ?>
        </h1>
        <p style="font-size: 36px;">
            <?= __('Your account has been successfully created.') ?>
        </p>
        <p style="font-size: 36px;">
            <?= __("Here's how our platform works.") ?>
        </p>
    </div>
</div>
