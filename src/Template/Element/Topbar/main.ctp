<?php
if (empty($mainNavigation)) {
    return;
}
?>

<ul class="nav navbar-nav">
    <?php
    foreach ($mainNavigation as $entry) {
        if ($entry instanceof \CrudView\Menu\MenuItem) {
            echo $this->element('menu/item', ['item' => $entry]);
        } elseif ($entry instanceof \CrudView\Menu\MenuDropdown) {
            echo $this->element('menu/dropdown', ['dropdown' => $entry]);
//        } elseif ($entry instanceof \CrudView\Menu\MenuDivider) {
//            echo '<hr />';
        } else {
            throw new Exception('Invalid Menu Item class');
        }
    }
    ?>
</ul>