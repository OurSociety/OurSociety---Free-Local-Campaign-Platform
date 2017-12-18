<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Layout\ProgressBar $progressBar
 */

$percentage = $progressBar->getPercentage();
?>

<div class="progress mb-3" style="height: 25px;">
    <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="<?= $percentage ?>"
         aria-valuemin="0" aria-valuemax="100" style="width: <?= $percentage ?>%;">
        <?php if ($percentage > 10): ?>
            <?= $percentage ?>%
        <?php endif ?>
    </div>
</div>
