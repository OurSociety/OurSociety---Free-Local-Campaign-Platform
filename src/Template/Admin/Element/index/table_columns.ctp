<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var string $displayField
 * @var array $fields
 * @var string $singularVar
 */
?>
<?php foreach ($fields as $field => $options): ?>
    <?php
    $tag = 'td';
    $tdOptions = $options['td'] ?? [];
    unset($options['td']);
    if ($field === $displayField):
        $tag = 'th';
        $tdOptions += ['scope' => 'row'];
    endif;
    ?>
    <?= $this->Html->tag(
        $tag,
        $this->CrudView->process($field, $singularVar, $options),
        $tdOptions) ?>
<?php endforeach;
