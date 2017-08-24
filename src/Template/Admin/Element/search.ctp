<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 */
if (empty($searchInputs)) {
    return;
}
?>

<div class="row-fluid search-filters">
    <?php
    $searchOptions = $searchOptions ?? [];
    $searchOptions += ['align' => 'inline', 'id' => 'searchFilter'];

    echo $this->Form->create(null, $searchOptions);
    echo $this->Form->hidden('_search');
    ?>

        <?= $this->Form->controls($searchInputs, ['fieldset' => false]); ?>
        <?= $this->Form->button('Filter results', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

    <?= $this->Form->end(); ?>
</div>
