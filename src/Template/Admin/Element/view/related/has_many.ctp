<?php
/**
 * @var \OurSociety\View\AppView $this The view class.
 * @var string $viewVar The view variable containing the entity.
 */
use Cake\Utility\Inflector;

$associations = array_merge($associations['oneToMany'] ?? [], $associations['manyToMany'] ?? []);
$i = 0;
?>
<?php foreach ($associations as $alias => $details): ?>
    <?php
    $entity = ${$viewVar};
    $assocSingularVar = $details['propertyName'];
    $associationName = $details['entities'];
    /** @var \Cake\ORM\Entity[] $associatedEntities */
    $associatedEntities = $entity->{$associationName};
    ?>
    <div class="col">
        <div class="card mb-3 related">
            <div class="card-body">
                <div class="actions-wrapper pull-right">
                    <?= $this->CrudView->createRelationLink($alias, $details, array('class' => 'btn btn-primary'));?>
                </div>
                <h3><?= __d('crud', 'Related {0}', [Inflector::humanize($details['controller'])]); ?></h3>
            </div>
            <?php if ($associatedEntities): ?>
            <table class="table table-bordered table-hover mb-0">
                <thead>
                <tr>
                    <?php
                    $otherFields = array_keys($associatedEntities[0]->toArray());

                    if (isset($details['with'])) {
                        $index = array_search($details['with'], $otherFields, true);
                        unset($otherFields[$index]);
                    }
                    ?>
                    <?php foreach ($otherFields as $field): ?>
                        <th><?= Inflector::humanize($field) ?></th>
                    <?php endforeach ?>
                    <th class="actions">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; foreach ($associatedEntities as ${$assocSingularVar}): ?>
                    <tr>
                        <?php foreach ($otherFields as $field): ?>
                            <td><?= $this->CrudView->process($field, ${$assocSingularVar}); ?></td>
                        <?php endforeach ?>
                        <td class="actions">
                            <div class="btn-group" role="group" aria-label="Actions">
                                <?= $this->Html->link(
                                    $this->Html->icon('search'),
                                    ['plugin' => $details['plugin'], 'controller' => $details['controller'], 'action' => 'view', ${$assocSingularVar}[$details['primaryKey']]],
                                    ['title' => __d('crud', 'View'), 'class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                                <?= $this->Html->link(
                                    $this->Html->icon('pencil'),
                                    ['plugin' => $details['plugin'], 'controller' => $details['controller'], 'action' => 'edit', ${$assocSingularVar}[$details['primaryKey']]],
                                    ['title' => __d('crud', 'Edit'), 'class' => 'btn btn-warning btn-sm', 'escape' => false]) ?>
                                <?= $this->Html->link(
                                    $this->Html->icon('trash'),
                                    ['plugin' => $details['plugin'], 'controller' => $details['controller'], 'action' => 'delete', ${$assocSingularVar}[$details['primaryKey']]],
                                    ['title' => __d('crud', 'Delete'), 'class' => 'btn btn-danger btn-sm', 'escape' => false]) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <?php endif ?>
        </div>
    </div>
<?php endforeach ?>
