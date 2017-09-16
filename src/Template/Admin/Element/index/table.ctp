<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var array $bulkActions The list of bulk actions.
 * @var string $primaryKey The name of the primary key field.
 * @var string $singularVar The name of the variable field for a single record.
 * @var \Cake\ORM\ResultSet $records The records.
 * @var string $viewVar The name of the variable containing the records.
 */

$records = ${$viewVar};
$actionsExist = !empty($actions['entity']);
?>

<div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
        <thead>
            <tr>
                <?= $this->element('index/bulk_actions/table', [
                    'bulkActions' => $bulkActions,
                    'primaryKey' => $primaryKey,
                    'singularVar' => $singularVar,
                ]) ?>
                <?php if ($actionsExist): ?>
                    <th><?= __d('crud', 'Actions') ?></th>
                <?php endif ?>
                <?php foreach ($fields as $field => $options): ?>
                    <?php
                    $value = $title = $options['title'] ?? \Cake\Utility\Inflector::humanize($field);
                    if (empty($options['disableSort'])):
                        $value = $this->Paginator->sort($field, $title, $options);
                    endif;
                    ?>
                    <th><?= $value ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $singularVar): ?>
                <tr>
                    <?= $this->element('index/bulk_actions/record', [
                        'bulkActions' => $bulkActions,
                        'primaryKey' => $primaryKey,
                        'singularVar' => $singularVar,
                    ]) ?>
                    <?php if ($actionsExist): ?>
                        <td class="actions">
                            <?= $this->element('actions', [
                                'singularVar' => $singularVar,
                                'actions' => $actions['entity']
                            ]) ?>
                        </td>
                    <?php endif ?>
                    <?= $this->element('index/table_columns', ['entity' => $singularVar]) ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
