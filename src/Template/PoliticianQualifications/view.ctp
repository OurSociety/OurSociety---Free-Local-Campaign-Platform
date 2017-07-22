<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianQualification $politicianQualification
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Politician Qualification'), ['action' => 'edit', $politicianQualification->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Politician Qualification'), ['action' => 'delete', $politicianQualification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianQualification->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Politician Qualifications'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Politician Qualification'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="politicianQualifications view large-9 medium-8 columns content">
    <h3><?= h($politicianQualification->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($politicianQualification->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Politician Id') ?></th>
            <td><?= h($politicianQualification->politician_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($politicianQualification->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Institution') ?></th>
            <td><?= h($politicianQualification->institution) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started') ?></th>
            <td><?= h($politicianQualification->started) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ended') ?></th>
            <td><?= h($politicianQualification->ended) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($politicianQualification->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($politicianQualification->modified) ?></td>
        </tr>
    </table>
</div>
