<li class="nav-item">
    <?= $this->Html->link(
        $item->getTitle(),
        $item->getUrl(),
        \Cake\Utility\Hash::merge($item->getOptions(), ['class' => ['nav-link']])
    ); ?>
</li>
