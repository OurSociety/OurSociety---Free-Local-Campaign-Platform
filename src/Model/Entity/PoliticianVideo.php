<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

/**
 * PoliticianVideo Entity
 *
 * @property string $id
 * @property string $politician_id
 * @property string $youtube_video_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \OurSociety\Model\Entity\Politician $politician
 * @property string $youtube_video_url
 * @property string $youtube_video_thumbnail
 */
class PoliticianVideo extends AppEntity
{
    protected function _getYoutubeVideoThumbnail(): string
    {
        return sprintf('http://img.youtube.com/vi/%s/mqdefault.jpg', $this->youtube_video_id);
    }

    protected function _getYoutubeVideoUrl(): string
    {
        return sprintf('https://www.youtube.com/watch?v=%s', $this->youtube_video_id);
    }
}
