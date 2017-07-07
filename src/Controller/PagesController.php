<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * {@inheritdoc}.
     *
     * - Grants public access to all static pages.
     */
    public function beforeFilter(Event $event): void
    {
        parent::beforeFilter($event);

        $this->Auth->allow('display');
    }

    /**
     * Displays a view
     *
     * @param string|string[] ...$path Path segments.
     * @return Response|null
     * @throws ForbiddenException When a directory traversal attempt.
     * @throws NotFoundException When the view file could not and debug mode is disabled.
     * @throws MissingTemplateException When the view file could not be found and debug mode is enabled.
     */
    public function display(string ...$path): ?Response
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}
