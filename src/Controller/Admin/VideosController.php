<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\Video;
use OurSociety\View\AppView;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Videos Controller
 *
 * @method Video[] paginate($object = null, array $settings = [])
 */
class VideosController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'politician_id',
                    'youtube_video_id' => [
                        'title' => 'YouTube Video',
                        'formatter' => function (string $name, string $value, Video $video) {
                            /** @var AppView $view */
                            $view = $this->createView();

                            return $view->Video->embed(
                                $video->youtube_video_url,
                                ['width' => '100%', 'height' => 300, 'failSilently' => true]
                            );
                        },
                    ],
                    'featured' => ['title' => 'Featured?'],
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->on('afterFind', function (Event $event) {
            /** @var Video $video */
            $video = $event->getSubject()->entity;

            return $event->getSubject()->success === true
                ? $this->redirect($video->youtube_video_url)
                : null;
        });

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        return $this->_form();
    }

    public function edit(): ?Response
    {
        return $this->_form();
    }

    private function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'politician_id',
                    'youtube_video_id' => [
                        'label' => 'YouTube Video ID',
                        'type' => 'text',
                        'help' => 'The portion of the YouTube video URL after the <code>v=</code> '
                            . '(ie. The <code>W7NNOfkcKRg</code> in <code>https://www.youtube.com/watch?v=W7NNOfkcKRg</code>)',
                    ],
                    'featured' => [
                        'label' => 'Feature This Video?',
                        'help' => 'If checked, this video will be displayed first and at full size.',
                    ],
                ],
            ],
        ]);

        return $this->Crud->execute();
    }
}
