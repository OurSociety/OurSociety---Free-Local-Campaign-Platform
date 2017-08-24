<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\User $mayor The mayor.
 */

if ($mayor === null) {
    $mayor = \OurSociety\Model\Entity\User::example([
        'name' => 'Example Mayor',
        'email' => 'mayor@example.com',
        'office_type' => new \OurSociety\Model\Entity\OfficeType(['name' => 'Mayor']),
    ]);
}
?>

<div<?= $mayor->is_example ? ' class="example"' : null ?>>

    <?php if ($mayor->picture !== null): ?>
        <img class="card-img" src="<?= $mayor->picture ?>" alt="Card image">
    <?php else: ?>
        <?= $this->Html->jdenticon($mayor->id) ?>
    <?php endif ?>

    <p class="h5 mt-2 mb-0">
        <?= $mayor->name ?>
        <small class="text-muted"><?= $mayor->office_type->name ?></small>
    </p>

    <i class="fa fa-fw fa-envelope"></i> <?= $this->Html->email($mayor->email) ?>

</div>
