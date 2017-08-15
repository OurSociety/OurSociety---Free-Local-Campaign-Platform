<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Candidate $candidate
 */
?>

<div class="media">
    <div class="media-left">
        <?= $this->Html->politicianLink(
            $candidate->politician,
            $this->Html->jdenticon($candidate->politician->slug, [
                'class' => ['media-object'],
                'alt' => __('Profile picture of {politician_name}', ['politician_name' => $candidate->politician->name]),
                'height' => '150',
            ]),
            ['escape' => false]
        ) ?>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= $this->Html->politicianLink($candidate->politician) ?></h4>
        <p><?= $candidate->politician->incumbent === true
                ? $candidate->politician->position ?? __('Unknown Position')
                : __('Candidate for {position}', [
                    'position' => $candidate->politician->position ?? __('Unknown Position')
                ]) ?></p>
        <dl class="dl-horizontal">
            <dt>Questions answered</dt>
            <dd><?= $candidate->politician->answer_count ?></dd>
            <dt>Articles posted</dt>
            <dd><?= count($candidate->politician->articles) ?></dd>
            <dt>Videos uploaded</dt>
            <dd><?= count($candidate->politician->awards) ?></dd>
            <dt>Previous positions</dt>
            <dd><?= count($candidate->politician->positions) ?></dd>
            <dt>Qualifications</dt>
            <dd><?= count($candidate->politician->qualifications) ?></dd>
        </dl>
    </div>
</div>
