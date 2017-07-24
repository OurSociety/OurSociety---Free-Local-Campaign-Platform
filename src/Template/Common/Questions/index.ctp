<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 */
?>
<?= $this->fetch('breadcrumbs') ?>

<?= $this->fetch('actions') ?>

<h2><?= $this->fetch('heading', __("Let's find common ground, share your perspective.")) ?></h2>

<hr>

<p><?= __($this->fetch('introduction'), ['count' => count($questions)]) ?></p>

<section class="well well-sm">
    <?= $this->cell('Common/Question::batch', [$questions]) ?>
</section>
