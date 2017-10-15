<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Listing\TableHead $tableHead
 */
?>

<thead>
<tr>

    <?php if ($tableHead->hasButtons() === true): ?>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    <?php endif ?>

    <?php foreach ($tableHead->getFieldList() as $field): ?>
        <th scope="col" class="text-nowrap">
            <?= $this->Paginator->sort(
                $field->getName(),
                $field->hasTitle() ? $field->getTitle() : null
            ) ?>
        </th>
    <?php endforeach ?>

</tr>
</thead>
