<?php
/**
 * Dashboard view.
 *
 * Sets up time range switched. Extended by other dashboard view.
 *
 * @var \OurSociety\View\AppView $this
 */
$defaultRange = 'week';
$ranges = [
    $defaultRange => __('Weekly'),
    'month' => __('Monthly'),
    'year' => __('Yearly'),
];
?>

<?php if (!$this->exists('breadcrumb-actions')): ?>
<?php $this->start('breadcrumb-actions') ?>
<div class="btn-group" role="group" aria-label="Basic example">
    <?php foreach ($ranges as $name => $label): ?>
        <?php
        $options = ['class' => ['btn', 'btn-light'], 'role' => 'button'];
        if ($this->request->getQuery('range') === $name) {
            $options['class'][] = 'active';
            $options['aria-pressed'] = true;
        }
        ?>
        <?= $this->Html->link($label, ['?' => ['range' => $name]], $options) ?>
    <?php endforeach ?>
</div>
<?php $this->end() ?>
<?php endif ?>

<?= $this->fetch('dashboard') ?>
