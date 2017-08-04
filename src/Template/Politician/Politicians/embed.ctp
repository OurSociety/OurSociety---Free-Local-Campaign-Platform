<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician
 */
$embedCode = sprintf('<script src="%s"></script>', $this->Url->build(
    sprintf('/js/embed.js?politician=%s', $politician->slug),
    ['fullBase' => true]
));
?>

<ol class="breadcrumb">
    <li><?= $this->Html->dashboardLink() ?></li>
    <li><?= $this->Html->link('Profile', ['_name' => 'politician:profile']) ?></li>
    <li><?= __('Profile') ?></li>
</ol>

<div class="row">

    <div class="col-xs-6">
        <h2>Embed Your Profile</h2>

        <p>Feel free to embed your profile as a widget in your own website!</p>

        <p>Simply code and paste the <kbd><?= htmlentities('<script>') ?></kbd> tag below into your page:</p>

        <pre><code><?= htmlentities($embedCode) ?></code></pre>

        <p>The script will insert an <kbd><?= htmlentities('<iframe>') ?></kbd> as seen on the right:</p>
    </div>

    <div class="col-xs-6">
        <?= $embedCode ?>
    </div>

</div>
