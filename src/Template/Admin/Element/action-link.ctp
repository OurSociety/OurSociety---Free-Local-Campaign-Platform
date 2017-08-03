<?php
/**
 * @var array $config
 */

$config['options']['class'] = null; // Remove button classes.

switch ($config['title']):
    case 'Index': $config['title'] = 'List ' . ucfirst($pluralVar); break;
    case 'View': $config['title'] = 'View ' . $singularVar; break;
    case 'Add': $config['title'] = 'Add a ' . $singularVar; break;
    case 'Edit': $config['title'] = 'Edit ' . $singularVar; break;
endswitch;
?>

<li class="toc-entry toc-h2">
    <?php if (!is_array($config)): ?>
        <?= $config ?>
    <?php elseif ($config['method'] !== 'GET'): ?>
        <?= $this->Form->postLink($config['title'], $config['url'], $config['options']) ?>
    <?php else: ?>
        <?= $this->Html->link($config['title'], $config['url'], $config['options']) ?>
    <?php endif ?>
</li>
