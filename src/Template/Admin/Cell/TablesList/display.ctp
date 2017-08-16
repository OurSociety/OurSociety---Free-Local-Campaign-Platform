<?php foreach ($tables as $table => $config): ?>
    <?php
    $active = false; // TODO: Determine active route.
    ?>
    <?php if ($active === true): ?>
        <li class="nav-item">
            <?= $this->Html->link($config['title'] . ' <span class="sr-only">(current)</span>', [
                'controller' => $config['controller'],
                'action' => $config['action'],
            ], ['class' => 'nav-link active', 'escape' => false]) ?>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <?= $this->Html->link($config['title'], [
                'controller' => $config['controller'],
                'action' => $config['action'],
            ], ['class' => 'nav-link']) ?>
        </li>
    <?php endif ?>
<?php endforeach ?>
