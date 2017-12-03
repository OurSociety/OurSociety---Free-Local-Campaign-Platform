<?php
/**
 * @var \OurSociety\Model\Entity\Answer $record
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $identity
 */

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Voice'), ['_name' => 'citizen:questions']);
$this->Breadcrumbs->add(__('Review Answers'), ['_name' => 'citizen:answers']);

$answer = $record;
/** @var \OurSociety\Model\Entity\Question $question */
$question = $record->question;
?>

<?= $this->Form->create($answer) ?>
<?= $this->cell('Common/Question', [$question, null, $answer]) ?>
<div class="row mt-3">
    <div class="col-md-6 ml-auto">
        <?= $this->Form->submit('Revise answer', ['class' => ['btn-block']]) ?>
    </div>
</div>
<?= $this->Form->end() ?>
