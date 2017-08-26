<?php
/**
 * @var \OurSociety\View\AppView $this
 */
?>
<hr>

<footer class="row">
    <div class="col-xs-12">
        <p><?= $this->Html->image('../img/banner.png', ['style' => 'height: 50px']) ?></p>
        <ul class="list-unstyled">
            <li><?= $this->Html->email('info@oursociety.org') ?></li>
            <li><a href="#">Menu Item #1</a></li>
            <li><a href="#">Menu Item #2</a></li>
            <li><a href="#">Menu Item #3</a></li>
        </ul>
        <p class="text-center text-muted small">Disclaimer, copyright</p>
    </div>
</footer>
