<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Component\Detail\Show $show
 */
?>

<div class="card">

    <h4 class="card-header">
        <?= $this->Component->render($show->getIcon()) ?>
        <?= $show->getRecordTitle() ?>
        <span class="pull-right">
            <?= $this->Component->render($show->getButtonGroup()) ?>
        </span>
    </h4>

    <div class="card-body p-0">

        <table class="table table-striped mb-0">
            <thead class="sr-only">
            <tr>
                <th scope="col">
                    <?= __('Field') ?>
                </th>
                <th scope="col">
                    <?= __('Value') ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($show->getFields() as $field): ?>
                <tr>
                    <th scope="row">
                        <?= $field->getTitle() ?>
                    </th>
                    <td>
                        <?= $this->Component->render($show->buildField($field)) ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>

</div>
