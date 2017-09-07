<?php
/**
 * @var \OurSociety\View\AppView $this View class.
 * @var \OurSociety\Model\Entity\PoliticianVideo[] $videos The videos.
 */

$isExample = count($videos) === 0;
if ($isExample) {
    $videos = \OurSociety\Model\Entity\PoliticianVideo::examples(5);
}

$featuredVideo = array_shift($videos);
?>

<h3>
    <?= __('Recent Videos') ?>
</h3>

<div class="card text-center <?= $isExample ? ' example' : null ?> mb-3">
    <div class="card-body p-0 bg-light">
        <?php if ($featuredVideo->is_example): ?>
            <img src="/img/svg/video-placeholder.svg">
        <?php else: ?>
            <?= $this->Video->embed($featuredVideo->youtube_video_url) ?>
        <?php endif ?>
    </div>
    <?php if (count($videos) > 0): ?>
        <div class="card-footer carousel carousel-video">
            <ul class="nav nav-pills card-header-pills  mb-0">
                <?php foreach ($videos as $video): ?>
                    <li class="nav-item pr-2">
                        <a class="" href="#">
                            <?php if ($video->is_example): ?>
                                <img src="/img/svg/video-placeholder.svg" style="height: 70px">
                            <?php else: ?>
                                <img class="img-thumbnail" src="<?= $video->youtube_video_thumbnail ?>" style="height: 70px">
                            <?php endif ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
            <?php if (!$featuredVideo->is_example): ?>
                <a class="carousel-control-next" role="button">
                    <span class="carousel-control-next-icon" href="#" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>
