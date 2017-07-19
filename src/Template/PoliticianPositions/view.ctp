<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\PoliticianPosition $politicianPosition
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Politician Position'), ['action' => 'edit', $politicianPosition->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Politician Position'), ['action' => 'delete', $politicianPosition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $politicianPosition->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Politician Positions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Politician Position'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="politicianPositions view large-9 medium-8 columns content">
    <h3><?= h($politicianPosition->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($politicianPosition->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Politician Id') ?></th>
            <td><?= h($politicianPosition->politician_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($politicianPosition->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company') ?></th>
            <td><?= h($politicianPosition->company) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started') ?></th>
            <td><?= h($politicianPosition->started) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ended') ?></th>
            <td><?= h($politicianPosition->ended) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($politicianPosition->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($politicianPosition->modified) ?></td>
        </tr>
    </table>
</div>
