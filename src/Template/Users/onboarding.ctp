<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \OurSociety\Model\Entity\User $user The user entity.
 * @var \OurSociety\Model\Entity\User|null $currentUser The current user.
 */
?>

<div class="row">
    <div class="col-md-6 p-5 os-bg-split-light" style="min-height: 750px">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tutorial-1">
                <h1 class="pb-3">
                    <?= __('First, we give you a question about your values.') ?>
                </h1>

                <article class="card card-default js-question">
                    <h4 class="card-header">
                        <?= __('Question #{number}', ['number' => 1]) ?>
                    </h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-auto order-sm-12 text-center">
                                <?= $this->Html->icon('law', ['iconSet' => 'topic', 'height' => 100, 'width' => 100]) ?>
                            </div>
                            <div class="col-sm">
                                <blockquote class="blockquote">
                                    <p>
                                        <?= __(implode(' ', [
                                            "Contracts to obtain, retain, profit from, manage, or dispose of one's",
                                            'private property should be regulated by the government.'
                                        ])) ?>
                                    </p>
                                    <footer class="blockquote-footer">
                                        <?= __('Category') ?>:
                                        <cite>
                                            <?= __('Law') ?>
                                        </cite>
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="nav pt-3 pull-right">
                    <a href="#tutorial-2" aria-controls="tutorial-2" role="tab" data-toggle="tab" class="btn btn-primary">
                        <?= __('Continue') ?>
                    </a>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tutorial-2">
                <h1 class="pb-3">
                    <?= __('Then, you choose whether you agree or disagree.') ?>
                </h1>

                <article class="card card-default js-question">
                    <h4 class="card-header">
                        <?= __('Question #{number}', ['number' => 1]) ?>
                    </h4>
                    <div class="card-body">
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

                <div class="nav pt-3 pull-right">
                    <a href="#tutorial-3" aria-controls="tutorial-3" role="tab" data-toggle="tab" class="btn btn-primary">
                        <?= __('Continue') ?>
                    </a>
                    <!--
                    <a href="#tutorial-1" aria-controls="tutorial-1" role="tab" data-toggle="tab" class="btn btn-link">
                        <?= __('Back') ?>
                    </a>
                    -->
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tutorial-3">
                <h1 class="pb-3">
                    <?= __('Finally, you tell us how important this topic is to you.') ?>
                </h1>

                <article class="card card-default js-question">
                    <h4 class="card-header"><?= __('Question #{number}', ['number' => 1]) ?></h4>
                    <div class="card-body">
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

                <div class="nav pt-3 pull-right">
                    <a href="#tutorial-4" aria-controls="tutorial-4" role="tab" data-toggle="tab" class="btn btn-primary">
                        <?= __('Continue') ?>
                    </a>
                    <!--
                    <a href="#tutorial-2" aria-controls="tutorial-2" role="tab" data-toggle="tab" class="btn btn-link">
                        <?= __('Back') ?>
                    </a>
                    -->
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tutorial-4">
                <h1 class="pb-3">
                    <?= __('If you are unsure, you can always choose to answer later.') ?>
                </h1>

                <article class="card card-default js-question">
                    <div class="card-header">
                        <div class="row">
                            <h4 class="col mb-0"><?= __('Question #{number}', ['number' => 1]) ?></h4>
                            <div class="col-auto text-muted">
                                <?= $this->Html->link(__('Answer Later'), '#', [
                                    'class' => ['btn', 'btn-link', 'text-secondary', 'disabled', 'p-0'],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="nav pt-3 pull-right">
                    <a href="#location" aria-controls="location" role="tab" data-toggle="tab" class="btn btn-primary">
                        <?= __('Continue') ?>
                    </a>
                    <!--
                    <a href="#tutorial-3" aria-controls="tutorial-3" role="tab" data-toggle="tab" class="btn btn-link">
                        <?= __('Back') ?>
                    </a>
                    -->
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="location">
                <h1 class="pb-3">
                    <?= __('Please select your location to continue!') ?>
                </h1>

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
                <?= $this->Form->button(__('Save'), ['class' => ['btn-primary', 'pull-right']]) ?>
                <!--
                <a href="#tutorial-4" aria-controls="tutorial-4" role="tab" data-toggle="tab" class="btn btn-link">
                    <?= __('Back') ?>
                </a>
                -->
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 p-5 text-white os-bg-split-dark" style="background-color: #871898">
        <h1 class="display-4 mb-5" style="font-weight: bold">
            <?= __('Congratulations!') ?>
        </h1>
        <h1 class="mb-5">
            <?= __('Your account has been successfully created.') ?>
        </h1>
        <h2>
            <?= __("Here's how our platform works.") ?>
        </h2>
    </div>
</div>
