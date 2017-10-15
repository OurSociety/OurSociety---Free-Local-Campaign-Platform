<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 * @var \OurSociety\Model\Entity\User $politician The currently viewed politician.
 * @var \OurSociety\Model\Entity\User $identity The currently authenticated user.
 * @var bool $edit True if editing profile, false otherwise.
 */

$email = $politician->verified === null ? $politician->email : $politician->email_temp;
?>

<h2>
    <?= $politician->name ?>
    <div class="pull-right">
        <?= $this->fetch('actions_heading') ?>
    </div>
</h2>

<hr>

<?php if ($politician->id === $identity->id): ?>
    <?= $this->element('../Citizen/CommunityContributors/banner') ?>
<?php endif ?>

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

            <?= $this->cell('Profile/ValueMatch', [$politician, $identity, 3]) ?>
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

<hr>

<section>
    <h3><?= __('About {name}', ['name' => $this->request->getParam('id') ? $politician->name : __('me')]) ?></h3>
    <div class="row">
        <div class="col-md-8">
            <?= $this->element('Widgets/PoliticianProfile/positions') ?>
            <?= $this->element('Widgets/PoliticianProfile/qualifications') ?>
            <?= $this->element('Widgets/PoliticianProfile/awards') ?>
        </div>
        <div class="col-md-4">
            <?= $this->element('Widgets/PoliticianProfile/born') ?>
        </div>
    </div>
</section>
