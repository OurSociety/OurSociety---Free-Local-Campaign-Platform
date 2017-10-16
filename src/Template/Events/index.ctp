<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var \Cake\ORM\ResultSet|\OurSociety\Model\Entity\Event[] $events The events.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */

$this->set('title', sprintf('Events in %s', $municipality->display_name));

$this->Breadcrumbs->add(__('Municipalities'), $municipality->getBrowseRoute());
$this->Breadcrumbs->add($municipality->name, $municipality->getViewRoute());
$this->Breadcrumbs->add(__('Upcoming Events'));
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('My Municipality'), ['_name' => 'municipality:default']) ?></li>
    <li class="breadcrumb-item"><?= $this->Html->link($municipality->display_name, $municipality->getViewRoute()) ?></li>
    <li class="breadcrumb-item active"><?= __('Upcoming Events') ?></li>
</ol>

<h1>
    <?= __('Upcoming Events') ?>
</h1>

<?php if (count($events) === 0): ?>
    <p>
        <?= __('There are no events happening in {municipality}.', [
            'municipality' => $this->Html->link($municipality->display_name, $municipality->getViewRoute()),
        ]) ?>
    </p>
<?php else: ?>
    <p>
        <?= __('The following events are happening in {municipality}:', [
            'municipality' => $this->Html->link($municipality->display_name, $municipality->getViewRoute()),
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
