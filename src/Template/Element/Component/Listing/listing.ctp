<?php

use OurSociety\View\Component\Listing\Paginator;
use OurSociety\View\Component\Listing\Table;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\Listing $listing
 */
?>

<div class="card">

    <h4 class="card-header">
        <?= $this->Html->icon($listing->getIcon(), ['class' => 'fa-fw']) ?>
        <?= __($listing->getHeading()) ?>
        <span class="pull-right">
            <?= $this->Component->render($listing->getButtonGroup(OurSociety\View\Component\Button\Button::SCOPE_REPOSITORY)) ?>
        </span>
    </h4>

    <div class="card-body p-0">

        <?= $this->Component->render(new Table(
            $listing->getRecords(),
            $listing->getFields(),
            $listing->getRecordButtons()
        )) ?>

    </div>

    <div class="card-footer text-muted">
        <?= $this->Component->render(new Paginator) ?>
    </div>

</div>
