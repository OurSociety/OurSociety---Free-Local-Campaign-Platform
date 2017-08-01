<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var string $url The URL of the current picture.
 * @var \OurSociety\Model\Entity\User $user
 */
$alternateText = __('Profile picture of {user_name}', [
    'user_name' => $user->name,
]);
$pictureUrl = $this->Url->assetUrl(sprintf('/upload/profile/picture/%s/%s', $user->id, $user->picture));
$imageData = [
    'pictureUrl' => $pictureUrl,
    'slug' => $user->slug,
    'alternateText' => $alternateText,
];
?>

<div id="app">
    <!--suppress HtmlUnknownTag -->
    <profile-picture :image-data='<?= htmlspecialchars(json_encode($imageData)) ?>'>

        <?= $this->Html->image($user, [
            'alt' => __('Profile picture of {user_name}', ['user_name' => $user->name]),
            'class' => ['img-responsive'],
        ]) ?>

    </profile-picture>
</div>
