<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use OurSociety\Controller\AppController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Submissions Controller
 *
 * @property \OurSociety\Model\Table\SubmissionsTable $Submissions
 */
class SubmissionsController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $submission = $this->Submissions->newEntity();

        if ($this->request->is('post')) {
            $submission = $this->Submissions->patchEntity($submission, $this->request->getData());

            if ($this->Submissions->save($submission)) {
                $this->Flash->success(__('Your submission has been received. We will review it soon!'));

                return $this->redirect($this->getCurrentUser()->getDashboardRoute());
            }

            $this->Flash->error(__('There was a problem with your submission. Please, try again.'));
        }

        $this->set(compact('submission'));
        $this->set('_serialize', ['submission']);

        return null;
    }
}
