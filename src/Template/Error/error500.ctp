<?php
/**
 * @var string $message The error message.
 * @var string $url The URL of the page.
 * @var \OurSociety\View\AppView $this
 */

use Cake\Core\Configure;

//$this->layout = 'error';
if (Configure::read('debug') === true) {
    echo $this->element('Error/debug', compact('code', 'message', 'url'));

    return;
}

$links = [
    'url' => $this->Html->link($this->Url->build($url, true), $url),
    'contact' => $this->Html->link(__('contact'), ['_name' => 'contact']),
    'refreshing' => $this->Html->link(__('refreshing'), 'javascript:window.location.reload(true)'),
    'homepage' => $this->Html->link(__('homepage'), ['_name' => 'home']),
];
?>

<div class="jumbotron">
    <div class="container">

        <h1><?= __('Sorry!') ?></h1>

        <?php if ($message !== 'An Internal Error Has Occurred.') : ?>

            <p><?= $message ?></p>

        <?php else: ?>

            <p><?= __('Something went terribly wrong on {url}.', $links) ?></p>

            <p>
                <?= __('We track these errors automatically, but if the problem persists feel free to {contact} us.', $links) ?>
            </p>

            <p><?= __('In the meantime, try {refreshing} or going to the {homepage}.', $links) ?></p>

        <?php endif; ?>

    </div>
</div>
