<?php
/**
 * Action button element.
 *
 * @var array $config
 * @var string $pluralVar
 * @var string $singularVar
 */
use Cake\Utility\Hash;

/**
 * Icon button.
 *
 * @param string $icon The icon.
 * @param string $title The title.
 * @return string The icon button.
 */
$iconButton = function (string $icon, string $title): string {
    return sprintf('<i class="fa fa-%s" title="%s"></i>', $icon, $title);
};

switch ($config['title']):
    case 'Index':
        $config['title'] = $iconButton('list', sprintf('List %s', $pluralVar));
        $config['options'] = Hash::merge($config['options'], ['class' => ['btn', 'btn-sm', 'btn-info']]);
        break;
    case 'View':
        $config['title'] = $iconButton('search', sprintf('View %s', $singularVar));
        $config['options'] = Hash::merge($config['options'], ['class' => ['btn', 'btn-sm', 'btn-info']]);
        break;
    case 'Add':
        $config['title'] = $iconButton('plus', sprintf('Add a %s', $singularVar));
        $config['options'] = Hash::merge($config['options'], ['class' => ['btn', 'btn-sm', 'btn-success']]);
        break;
    case 'Edit':
        $config['title'] = $iconButton('pencil', sprintf('Edit %s', $singularVar));
        $config['options'] = Hash::merge($config['options'], ['class' => ['btn', 'btn-sm', 'btn-warning']]);
        break;
    case 'Delete':
        $config['title'] = $iconButton('trash', sprintf('Delete %s', $singularVar));
        $config['options'] = Hash::merge($config['options'], ['class' => ['btn', 'btn-sm', 'btn-danger']]);
        break;
endswitch;
?>

<?php if (!is_array($config)): ?>
    <?= $config ?>
<?php elseif ($config['method'] !== 'GET'): ?>
    <?= $this->Form->postLink(
        $config['title'],
        $config['url'],
        $config['options']
        + ['escape' => false, 'class' => ['btn', 'btn-sm']]) ?>
<?php else: ?>
    <?= $this->Html->link(
        $config['title'],
        $config['url'],
        $config['options']
        + ['escape' => false, 'class' => ['btn', 'btn-sm']]) ?>
<?php endif ?>
