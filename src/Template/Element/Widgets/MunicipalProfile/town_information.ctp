<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */

$isExample = empty($municipality->description);
?>

<h5>Town information</h5>

<div<?= $isExample ? ' class="example"' : null ?>>
    <?php if ($municipality->description !== ''): ?>
        <?= $municipality->description ?>
    <?php else: ?>
        <p>
            <?= __('OurSociety depends on municipalities like yours to become involved in more transparent and accessible local government.') ?>
        </p>
        <p>
            <?= __('If you’re reading this message it is because your municipality has not yet signed up for the OurSociety experiment.') ?>
        </p>
        <p>
            <?= __('We’re in our Beta at the moment and working closely with specific towns, but we always have room for one more!') ?>
        </p>
        <p>
            <?= __('Please {contact_us} to let us know that you want us to contact your representatives about joining OurSociety.', [
                'contact_us' => $this->Html->email('info@oursociety.org', __('contact us'), [
                    'subject' => __('Please contact my municipality to join OurSociety!'),
                ]),
            ]) ?>
        </p>
        <p>
            <?= __('Or, if you prefer, contact them directly and tell them that as a citizen you want them to join OurSociety!') ?>
        </p>
    <?php endif ?>
</div>
