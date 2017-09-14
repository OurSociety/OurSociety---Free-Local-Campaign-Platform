<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $politician The politician.
 */
?>

<div class="politician-video politician-video-featured">
    <?php if ($politician->featured_video === null): ?>
        <p><?= __("This politician hasn't featured a YouTube video.") ?></p>
    <?php else: ?>
        <?= $politician->featured_video->renderEmbed($this) ?>
    <?php endif ?>
</div>

<?php if (count($politician->videos) === 0): ?>
    <p class="text-muted small"><?= __("This politician hasn't linked any additional YouTube videos.") ?></p>
<?php else: ?>
    <div class="row">
        <?php foreach ($politician->videos as $video): ?>
            <div class="col-md-6" style="margin-top: 15px">
                <div class="politician-video">
                    <?= $video->renderEmbed($this) ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
