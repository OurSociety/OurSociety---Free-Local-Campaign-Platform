<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\User[] $pathwayPoliticians The pathway politicians.
 */

$pathwayPoliticians = $pathwayPoliticians ?? [];
$actualCount = count($pathwayPoliticians);
$desiredCount = 5;

if ($actualCount < $desiredCount):
    $examplePathwayPoliticians = \OurSociety\Model\Entity\User::examples($desiredCount - $actualCount);
    $pathwayPoliticians = array_merge($pathwayPoliticians, $examplePathwayPoliticians);
endif;
?>

<h2>
    <?= __('Pathway Politicians') ?>
</h2>

<p>
    What is a pathway politician anyway?
    Varius natoque ad augue amet ante orci lectus morbi ut, ullamcorper dictum tortor sed dolor cursus urna eleifend,
    placerat malesuada himenaeos vitae sociosqu vivamus cras suspendisse.
    <?= $this->Html->link('Share your story!', '#') ?>
</p>

<div class="card-deck pt-2">
    <?php foreach ($pathwayPoliticians as $user): ?>
        <?= $user->renderCardElement($this) ?>
    <?php endforeach ?>
</div>
