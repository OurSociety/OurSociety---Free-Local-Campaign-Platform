<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\User[] $electedOfficials The elected officials.
 */

$isExample = count($electedOfficials) === 0;
if ($isExample):
    $electedOfficials = \OurSociety\Model\Entity\User::examples(5, [
        'name' => 'Example Elected Official',
        'email' => 'elected.official@example.com',
    ]);
endif;
?>

<h3 id="elected_officials">
    <?= __('Elected Officials') ?>
</h3>

<ul class="list-unstyled">
    <?php foreach ($electedOfficials as $user): ?>
        <li>
            <?= $user->renderSummaryElement($this) ?>
        </li>
    <?php endforeach; ?>
</ul>
