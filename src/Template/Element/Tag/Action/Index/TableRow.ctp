<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Action\Index\TableRow $tag
 */

use OurSociety\View\Tag\Action\Index\TableCell;

$entity = $tag->getEntity();
?>

<tr>
    <?php if ($tag->hasActions() === true): ?>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $entity->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $entity->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $entity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entity->id)]) ?>
        </td>
    <?php endif ?>
    <?php foreach ($tag->getFieldList() as $field): ?>
        <?php
        /* @var \OurSociety\View\Scaffold\Field $field */
        $name = $field->getName();
        $title = $field->hasTitle() ? $field->getTitle() : null;
        ?>
        <?= $this->Tag->render(new TableCell($tag, $field, $entity)) ?>
    <?php endforeach ?>
    <?php /*
    <td><?= h($entity->id) ?></td>
    <td><?= $entity->has('politician') ? $this->Html->link($entity->politician->name, ['controller' => 'Users', 'action' => 'view', $entity->politician->id]) : '' ?></td>
    <td><?= h($entity->slug) ?></td>
    <td><?= h($entity->name) ?></td>
    <td><?= $this->Number->format($entity->version) ?></td>
    <td><?= $entity->has('aspect') ? $this->Html->link($entity->aspect->name, ['controller' => 'Categories', 'action' => 'view', $entity->aspect->id]) : '' ?></td>
    <td><?= $entity->has('article_type') ? $this->Html->link($entity->article_type->name, ['controller' => 'ArticleTypes', 'action' => 'view', $entity->article_type->id]) : '' ?></td>
    <td><?= $entity->has('electoral_district') ? $this->Html->link($entity->electoral_district->label, ['controller' => 'ElectoralDistricts', 'action' => 'view', $entity->electoral_district->id]) : '' ?></td>
    <td><?= h($entity->approved) ?></td>
    <td><?= h($entity->published) ?></td>
    <td><?= h($entity->created) ?></td>
    <td><?= h($entity->modified) ?></td>
    */ ?>
</tr>
