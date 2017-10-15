<?php

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\ButtonGroup $buttonGroup
 */
?>

<div class="btn-group">
    <?php foreach ($buttonGroup->getButtons() as $button): ?>
        <?= $this->Component->render($button) ?>
    <?php endforeach ?>
</div>
