<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var array $bulkActions The list of bulk actions.
 * @var string $primaryKey The name of the primary key field.
 * @var string $singularVar The name of the variable field for a single record.
 */

if (empty($bulkActions)):
    return;
endif;
?>

<th class="bulk-action">
    <?= $this->Form->checkbox($primaryKey . '[_all]') ?>
</th>
