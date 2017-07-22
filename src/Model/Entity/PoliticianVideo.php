<?php
namespace OurSociety\Model\Entity;

use Cake\ORM\Entity;

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
 * @property string youtube_video_thumbnail
 */
class PoliticianVideo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getYoutubeVideoThumbnail(): string
    {
        return sprintf('http://img.youtube.com/vi/%s/mqdefault.jpg', $this->youtube_video_id);
    }

    protected function _getYoutubeVideoUrl(): string
    {
        return sprintf('https://www.youtube.com/watch?v=%s', $this->youtube_video_id);
    }
}
