<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 * @var \OurSociety\Model\Entity\User $currentUser The currently authenticated user.
 * @var bool $edit True if editing profile, false otherwise.
 */

$email = $politician->verified === null ? $politician->email : $politician->email_temp;
?>

<?= $this->fetch('breadcrumbs') ?>

<h2>
    <?= $politician->name ?>
    <div class="pull-right">
        <?= $this->fetch('actions_heading') ?>
    </div>
</h2>

<hr>

<section>
    <div class="row text-center">
        <div class="col-sm-4">
            <?= $this->fetch('profile_picture') ?>
            <p><?= $politician->phone ?></p>
            <p><?= $this->Html->link($email, sprintf('mailto:%s', $email)) ?></p>
        </div>
        <div class="col-sm-8">
            <div class="alert alert-info">
                <?= __('Candidates and elected officials receive matching functionality.') ?>
            </div>

            <?= $this->cell('Profile/ValueMatch', [$politician, $currentUser, 3]) ?>
        </div>
    </div>
</section>

<hr>

<section>
    <h3>
        <?= __('My platform') ?>
        <?= $this->fetch('actions_articles') ?>
    </h3>
    <?= $this->element('Widgets/MunicipalProfile/articles', [
        'municipality' => $politician->electoral_district,
        'articles' => $politician->articles,
    ]) ?>
</section>
