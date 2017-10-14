<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var string $url The URL of the current picture.
 * @var \OurSociety\Model\Entity\User $user
 */
$imageData = [
    'pictureUrl' => $this->Url->profilePicture($user),
    'slug' => $user->slug,
    'alternateText' => __('Profile picture of {user_name}', [
        'user_name' => $user->name,
    ]),
];
?>

<div id="app">
    <!--suppress HtmlUnknownTag -->
    <profile-picture :image-data='<?= htmlspecialchars(json_encode($imageData)) ?>'>

        <?= $user->renderProfilePicture($this) ?>

    </profile-picture>
</div>
