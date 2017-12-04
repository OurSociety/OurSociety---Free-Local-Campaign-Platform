<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\User $politician
 * @var \OurSociety\Model\Entity\User $identity
 */
$embedCode = sprintf('<script src="%s"></script>', $this->Url->build(
    sprintf('/js/embed.js?politician=%s', $politician->slug),
    ['fullBase' => true]
));

$this->Breadcrumbs->add(__('My Dashboard'), $identity->getDashboardRoute());
$this->Breadcrumbs->add(__('My Profile'), ['_name' => 'politician:profile']);
$this->Breadcrumbs->add(__('Embed Your Profile'));
?>

<h2>
    <?= __('Embed Your Profile') ?>
</h2>

<div class="row">

    <div class="col-6">
        <p>
            <?= __('Feel free to embed your profile as a widget in your own website!') ?>
        </p>
        <p>
            <?= __('Simply code and paste the {script} tag below into your page:', [
                'script' => $this->Html->tag('kbd', h('<script>')),
            ]) ?>
        </p>

        <pre><code><?= h($embedCode) ?></code></pre>
    </div>

    <div class="col-6">
        <p>
            <?= __('The script will insert an {iframe} as seen below:', [
                'iframe' => $this->Html->tag('kbd', h('<iframe>')),
            ]) ?>
        </p>

        <?= $embedCode ?>
    </div>

</div>
