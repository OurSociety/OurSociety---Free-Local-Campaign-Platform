<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\Video[] $videos The videos.
 */

$isExample = count($videos) === 0;
if ($isExample) {
    $videos = \OurSociety\Model\Entity\Video::examples(5);
}

//$featuredVideo = array_shift($videos);
?>

<h3>
    <?= __('Recent Videos') ?>
</h3>

<div class="card text-center <?= $isExample ? ' example' : null ?> mb-3">
    <div class="card-body p-0 bg-light tab-content">
        <?php $index = 1;
        foreach ($videos as $video): ?>
            <div id="video-<?= $index ?>" class="tab-pane fade<?= $index === 1 ? ' show active' : null ?>"
                 role="tabpanel" aria-labelledby="video-<?= $index ?>-thumbnail">
                <?php if ($video->is_example): ?>
                    <img src="/img/svg/video-placeholder.svg">
                <?php else: ?>
                    <?= $this->Video->embed($video->youtube_video_url) ?>
                <?php endif ?>
            </div>
            <?php $index++; endforeach ?>
    </div>
    <?php if (count($videos) > 0): ?>
        <div class="card-footer carousel carousel-video">
            <ul class="nav nav-tabs nav-pills card-header-pills mb-0" role="tablist">
                <?php $index = 1;
                foreach ($videos as $video): ?>
                    <li class="nav-item pr-2">
                        <a id="video-<?= $index ?>-thumbnail"
                           href="#video-<?= $index ?>"<?= $index === 1 ? ' class="active"' : null ?>
                           role="tab" aria-controls="video-<?= $index ?>"
                           aria-expanded="<?= $index === 1 ? 'true' : 'false' ?>"
                           data-toggle="tab">
                            <?php if ($video->is_example): ?>
                                <img src="/img/svg/video-placeholder.svg" style="height: 70px">
                            <?php else: ?>
                                <img class="img-thumbnail" src="<?= $video->youtube_video_thumbnail ?>"
                                     style="height: 70px">
                            <?php endif ?>
                        </a>
                    </li>
                    <?php $index++; endforeach ?>
            </ul>
            <?php if (false && !$featuredVideo->is_example): ?>
                <a class="carousel-control-next" role="button">
                    <span class="carousel-control-next-icon" href="#" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>
