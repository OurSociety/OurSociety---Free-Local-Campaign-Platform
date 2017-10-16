<?php

use OurSociety\View\Tag\Action\Index\TableRow;

/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\View\Tag\Action\Index\TableBody $tag
 */

?>

<tbody>
<?php foreach ($articles as $article): ?>
    <?= $this->Tag->render(new TableRow($tag, $article)) ?>
<?php endforeach; ?>
</tbody>
