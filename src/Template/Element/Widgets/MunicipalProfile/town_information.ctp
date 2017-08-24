<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality The municipality.
 */

$isExample = empty($municipality->description);
if ($isExample):
    $municipality->description = $this->Text->autoParagraph(implode(\Faker\Factory::create()->paragraphs(5), "\n\n"));
endif;
?>

<h5>Town information</h5>

<div<?= $isExample ? ' class="example"' : null ?>>
    <?= $municipality->description ?>
</div>
