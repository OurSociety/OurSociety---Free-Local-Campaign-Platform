<?php
/**
 * Admin view element for CrudView.
 *
 * @var \OurSociety\View\AppView $this The view.
 * @var array[] $fields The fields to display from CrudView 'scaffold.fields' config.
 * @var string $primaryKey The primary key field name.
 * @var string $viewVar The view variable name.
 */
use \Cake\Utility\Inflector;

$assocMap = isset($associations['manyToOne'])
    ? array_flip(collection($associations['manyToOne'])->extract('foreignKey')->toArray())
    : [];
?>
<?= $this->fetch('before_view'); ?>
<div class="<?= $this->CrudView->getCssClasses(); ?>">
    <?= $this->element('action-header') ?>
    <div class="card mb-3">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <?php
                $this->CrudView->setContext(${$viewVar});
                foreach ($fields as $field => $options):
                    if ($field === $primaryKey):
                        continue;
                    endif;
                    $title = array_key_exists($field, $assocMap)
                        ? Inflector::singularize(Inflector::humanize(Inflector::underscore($assocMap[$field])))
                        : $options['title'] ?? Inflector::humanize($field);
                    $value = $this->CrudView->process($field, ${$viewVar}, $options);
                    ?>
                    <tr>
                        <th><?= $title ?></th>
                        <td><?= $value ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
    <?= $this->element('view/related'); ?>
</div>
