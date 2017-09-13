<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Event[] $events The events.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default']) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link($municipality->display_name, ['_name' => 'municipality', 'municipality' => $municipality->slug]) ?></li>
    <li class="breadcrumb-item active"><?= __('Upcoming Events') ?></li>
</ol>

<h1>
    <?= __('Upcoming Events') ?>
</h1>

<?php if (count($events) === 0): ?>
    <p>
        <?= __('There are no events happening in {municipality}.', [
            'municipality' => $this->Html->link($municipality->display_name, ['_name' => 'municipality', 'municipality' => $municipality->slug])
        ]) ?>
    </p>
<?php else: ?>
    <p>
        <?= __('The following events are happening in {municipality}:', [
            'municipality' => $this->Html->link($municipality->display_name, ['_name' => 'municipality', 'municipality' => $municipality->slug])
        ]) ?>
    </p>

    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <?= $event->renderSummaryElement($this) ?>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
