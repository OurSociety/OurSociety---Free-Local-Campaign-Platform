<?php
/**
 * @var \OurSociety\View\AppView $this
 */

$this->Breadcrumbs->add('Dashboards', '/admin');
$this->Breadcrumbs->add('Questions Dashboard');

$this->extend('/Common/Dashboard/dashboard');

$this->start('dashboard');
$numbers = [
    ['name' => 'questions_answered_total', 'label' => '# Answers', 'style' => 'pink', 'icon' => 'question'],
    ['name' => 'questions_answered_citizens', 'label' => '# by Citizen', 'style' => 'green', 'icon' => 'question'],
    ['name' => 'questions_answered_politicians', 'label' => '# by Representative', 'style' => 'blue', 'icon' => 'question'],
    ['name' => 'questions_percentage_total', 'label' => '% Answered', 'style' => 'pink', 'icon' => 'percent'],
    ['name' => 'questions_percentage_citizens', 'label' => '% by Citizens', 'style' => 'green', 'icon' => 'percent'],
    ['name' => 'questions_percentage_politicians', 'label' => '% by Representatives', 'style' => 'blue', 'icon' => 'percent'],
];
?>
<div class="row pb-3">
    <?php foreach ($numbers as $number): ?>
        <div class="col-6 col-sm-4 col-xl-2">
            <?= $this->cell(
                'Dashboard/NumberWidget',
                [],
                ['period' => $this->request->getQuery('range', 'week')] + $number
            ) ?>
        </div>
    <?php endforeach ?>
</div>
<?php $this->end() ?>
