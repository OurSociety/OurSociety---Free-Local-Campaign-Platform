<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 */

$defaultLimit = \OurSociety\Model\Table\QuestionsTable::LIMIT_BATCH;
?>
<?= $this->fetch('breadcrumbs') ?>

<?= $this->fetch('actions') ?>

<h2>
    <div class="pull-right">
        <?= $this->Form->create(null, ['type' => 'GET', 'class' => 'form-inline']) ?>
        <?= $this->Form->control('limit', [
            'label' => false,
            'default' => $this->request->getQuery('limit', $defaultLimit),
            'options' => [
                1 => __('Single questions'),
                $defaultLimit => __('Batches of questions'),
            ],
            'onchange' => 'this.form.submit()',
        ]) ?>
        <?= $this->Form->end() ?>
    </div>
    <?= $this->fetch('heading', __("Let's find common ground, share your perspective.")) ?>
</h2>

<hr>

<p><?= __($this->fetch('introduction'), ['count' => count($questions)]) ?></p>

<section class="well well-sm">
    <?= $this->cell('Common/Question::batch', [$questions]) ?>
</section>
