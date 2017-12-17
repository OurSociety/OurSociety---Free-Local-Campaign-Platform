<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Politician\Profile;

use OurSociety\TestSuite\Behat\Page\Page;

/**
 * Edit video page.
 */
class EditVideo extends Page
{
    private const LABEL_BUTTON_SAVE = 'Save';
    private const LABEL_FIELD_IS_FEATURED = 'Feature This Video?';
    private const LABEL_FIELD_YOUTUBE_VIDEO_ID = 'YouTube Video ID';

    public function assertFeatured($isFeatured): void
    {
        $isFeatured
            ? $this->hasCheckedField(self::LABEL_FIELD_IS_FEATURED)
            : $this->hasUncheckedField(self::LABEL_FIELD_IS_FEATURED);
    }

    public function assertYoutubeVideoId($youtubeVideoId): void
    {
        $this->assertFieldValue(self::LABEL_FIELD_YOUTUBE_VIDEO_ID, $youtubeVideoId);
    }

    public function save(): void
    {
        $this->pressButton(self::LABEL_BUTTON_SAVE);
    }

    public function setAsFeatured($isFeatured): void
    {
        $isFeatured
            ? $this->checkField(self::LABEL_FIELD_IS_FEATURED)
            : $this->uncheckField(self::LABEL_FIELD_IS_FEATURED);
    }

    public function setYoutubeVideoId($youtubeVideoId): void
    {
        $this->fillField(self::LABEL_FIELD_YOUTUBE_VIDEO_ID, $youtubeVideoId);
    }

    protected function getPath(): string
    {
        return '/representative/profile/videos/edit/{videoId}';
    }
}
