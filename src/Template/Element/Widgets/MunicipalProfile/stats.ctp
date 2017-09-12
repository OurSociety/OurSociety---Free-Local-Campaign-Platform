<?php
/**
 * @var \OurSociety\Model\Entity\ElectoralDistrict $municipality
 */

$cards = [
    [
        'label' => 'Number of Citizens',
        'number' => $municipality->citizen_count,
        'mobile' => true,
    ],
    [
        'label' => 'Number of Politicians',
        'number' => $municipality->politician_count,
        'mobile' => false,
    ],
    [
        'label' => 'Articles Being Fact-Checked',
        'number' => $municipality->article_factcheck_count,
        'mobile' => false,
    ],
    [
        'label' => 'Number of Articles This Year',
        'number' => $municipality->article_year_count,
        'mobile' => false,
    ],
];
?>

<div class="card-group">
    <?php foreach ($cards as $card): ?>
        <div class="card mx-0 text-center<?= $card['mobile'] === false ? ' d-none d-md-block' : null ?>">
            <div class="card-block m-3">
                <h4 class="card-title">
                    <?= $card['number'] ?>
                </h4>
                <h6 class="card-subtitle text-muted">
                    <?= __($card['label']) ?>
                </h6>
            </div>
        </div>
    <?php endforeach ?>
</div>
