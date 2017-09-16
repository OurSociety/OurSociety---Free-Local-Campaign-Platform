<?php
/**
 * @var \OurSociety\View\AppView $this
 * @var \OurSociety\Model\Entity\Candidate $candidate
 */

if ($candidate->politician === null) {
    $candidate->politician = \OurSociety\Model\Entity\User::example(['slug' => \Cake\Utility\Text::uuid()]);
}
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
        <dl class="row">
            <dt class="col-sm-9"><?= __('Questions answered') ?></dt>
            <dd class="col-sm-3"><?= $candidate->politician->answer_count ?? 0 ?></dd>
            <dt class="col-sm-9"><?= __('Articles posted') ?></dt>
            <dd class="col-sm-3"><?= count($candidate->politician->articles) ?></dd>
            <dt class="col-sm-9"><?= __('Videos uploaded') ?></dt>
            <dd class="col-sm-3"><?= count($candidate->politician->awards) ?></dd>
            <dt class="col-sm-9"><?= __('Previous positions') ?></dt>
            <dd class="col-sm-3"><?= count($candidate->politician->positions) ?></dd>
            <dt class="col-sm-9"><?= __('Qualifications') ?></dt>
            <dd class="col-sm-3"><?= count($candidate->politician->qualifications) ?></dd>
        </dl>
    </div>
</div>
