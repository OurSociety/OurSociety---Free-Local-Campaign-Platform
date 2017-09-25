<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var User[] $pathwayPoliticians The pathway politicians.
 */

use OurSociety\Model\Entity\User;

$pathwayPoliticians = $pathwayPoliticians ?? [];
$actualCount = count($pathwayPoliticians);
$desiredCount = 5;

if ($actualCount < $desiredCount):
    $examplePathwayPoliticians = User::examples($desiredCount - $actualCount);
    $pathwayPoliticians = array_merge($pathwayPoliticians, $examplePathwayPoliticians);
endif;
?>

<h2>
    <?= __('Community Contributors') ?>
</h2>

<p>
    <?= __('Community Contributors are local citizens with a genuine interest in improving the community.') ?>
    <?= __('They are not running for elected office but have taken the time to develop great ideas for Policies and Plans that could impact your municipality.') ?>
</p>

<p>
    <?= __('Take time to read through their thoughts and vote them Up or Down after you analyze the content.') ?>
    <?= __('Your local elected officials will be reviewing popular concepts for implementation in your town!') ?>
</p>

<div class="card-deck pt-2">
    <?php foreach ($pathwayPoliticians as $user): ?>
        <?= $user->renderCardElement($this) ?>
    <?php endforeach ?>
</div>
