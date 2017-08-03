<?php
/**
 * @var string $viewVar The name of the variable containing the records.
 * @var \Cake\ORM\ResultSet $records The records.
 */
$records = ${$viewVar};
?>
<table class="table table-hover table-sm table-responsive table-striped">
    <thead>
    <tr>
        <?= $this->element('index/bulk_actions/table', compact('bulkActions', 'primaryKey', 'singularVar')) ?>
        <?php if ($actionsExist = !empty($actions['entity'])): ?>
            <th><?= __d('crud', 'Actions') ?></th>
        <?php endif ?>
        <?php foreach ($fields as $field => $options): ?>
            <th>
                <?= !empty($options['disableSort'])
                    ? $options['title'] ?? \Cake\Utility\Inflector::humanize($field)
                    : $this->Paginator->sort($field, $options['title'] ?? null, $options) ?>
            </th>
        <?php endforeach ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($records as $singularVar): ?>
        <tr>
            <?php if ($actionsExist): ?>
                <td class="actions"><?= $this->element('actions', [
                        'singularVar' => $singularVar,
                        'actions' => $actions['entity']
                    ]) ?></td>
            <?php endif ?>

            <?= $this->element('index/bulk_actions/record', compact('bulkActions', 'primaryKey', 'singularVar')) ?>
            <?= $this->element('index/table_columns', compact('singularVar')) ?>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
