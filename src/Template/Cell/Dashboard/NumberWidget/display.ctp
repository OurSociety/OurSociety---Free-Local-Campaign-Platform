<?php
/**
 * @var string $currentCount
 * @var string $icon
 * @var string $label
 * @var string $percentageChange
 * @var string $percentageChangeDirection
 * @var string $percentageChangeStyle
 * @var string $previousCount
 * @var string $style
 */
?>

<div class="card">
    <div class="card-body px-0 os-text-<?= $style ?> text-center">
        <h2><i class="fa fa-<?= $icon ?>"></i></h2>
        <span class="text-muted"><?= $label ?></span>
        <br>
        <h4><?= $currentCount ?></h4>
        <br>
        <span class="small os-text-<?= $percentageChangeStyle ?>">
            <i class="fa fa-arrow-circle-o-<?= $percentageChangeDirection ?>"></i> <?= $percentageChange ?>
            <br>
            <small class="text-muted"><?= __('Previously {0}', $previousCount) ?></small>
        </span>
    </div>
</div>
