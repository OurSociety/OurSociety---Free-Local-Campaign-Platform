<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\Utility\Text;
use OurSociety\View\AppView;

/**
 * Video entity.
 *
 * @property string $id
 * @property string $politician_id
 * @property string $youtube_video_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\User $politician
 * @property string $youtube_video_url
 * @property string $youtube_video_thumbnail
 * @property bool $is_example
 */
class Video extends AppEntity
{
    public static function example(): self
    {
        return new self(['id' => Text::uuid(), 'youtube_video_id' => 'C0DPdy98e4c', 'is_example' => true]);
    }

    public function renderEmbed(AppView $view): string
    {
        return $view->Video->embed($this->youtube_video_url);
    }

    public function getIcon(): string
    {
        return 'video-camera';
    }

    protected function _getYoutubeVideoThumbnail(): string
    {
        return $this->properties['youtube_video_thumbnail']
            ?? sprintf('https://img.youtube.com/vi/%s/mqdefault.jpg', $this->youtube_video_id);
    }

    protected function _getYoutubeVideoUrl(): string
    {
        return sprintf('https://www.youtube.com/watch?v=%s', $this->youtube_video_id);
    }
}
