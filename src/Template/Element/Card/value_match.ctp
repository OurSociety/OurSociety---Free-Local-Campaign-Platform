<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\ValueMatch|null $politicianMatch
 */

if ($politicianMatch === null) {
    return;
}

$politician = $politicianMatch->politician;
if ($politician === null) {
    return;
}

$profilePicture = $politician->renderProfilePicture($this, ['class' => 'img-thumbnail', 'style' => 'max-height: 100px']);
$profileLink = $this->Html->link($politician->name, $politician->getPublicProfileRoute());
?>

<div class="media">
    <div class="media-left pr-2">
        <?= $profilePicture ?>
    </div>
    <div class="media-body">
        <h4 class="media-heading">
            <?= $profileLink ?>
        </h4>
        <p>
            <?= __('Based on your answers so far, you are an {percentage_match}% match with {politician_name}.', [
                'percentage_match' => $politicianMatch->match,
                'politician_name' => $profileLink,
            ]) ?>
        </p>
    </div>
</div>
