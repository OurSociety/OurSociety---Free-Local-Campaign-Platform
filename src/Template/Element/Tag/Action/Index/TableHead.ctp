<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Action\Index\TableHead $tag
 */

$fieldList = $tag->getFieldList();
?>
<thead>
<tr>
    <?php if ($tag->hasActions() === true): ?>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    <?php endif ?>
    <?php foreach ($fieldList as $field): ?>
        <?php
        /* @var \OurSociety\View\Scaffold\Field $field */
        $name = $field->getName();
        $title = $field->hasTitle() ? $field->getTitle() : null;
        ?>
        <th scope="col"><?= $this->Paginator->sort($name, $title) ?></th>
    <?php endforeach ?>
</tr>
</thead>
