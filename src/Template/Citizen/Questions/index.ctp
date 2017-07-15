<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 */
?>
<ol class="breadcrumb">
    <li><?= $this->Html->link(
        __('{role} Dashboard', ['role' => ucfirst($currentUser->role)]),
        ['_name' => sprintf('%s:dashboard', $currentUser->role)
    ]) ?></li>
    <li>Your Voice</li>
</ol>

<h3><?= __("Let's find common ground, share your perspective.") ?></h3>
<p><?= __(
        'By answering the following {count} questions, we can let you know which politicians in your area agree with you.',
        ['count' => count($questions)]
    ) ?></p>
<section class="well well-sm">
    <?= $this->element('Questions/batch', ['questions' => $questions]) ?>
</section>
