<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Reports Controller
 *
 * @property \OurSociety\Model\Table\ReportsTable $Reports
 */
abstract class ReportsController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $question = $this->Reports->Questions->get($this->request->getQuery('question_id'));

        $report = $this->Reports->newEntity();

        if ($this->request->is('post')) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());

            if ($this->Reports->save($report)) {
                $this->Flash->success(__('Your report has been received. We will review it shortly!'));

                return $this->redirect($this->getIdentity()->getDashboardRoute());
            }

            $this->Flash->error(__('There was a problem with your report. Please, try again.'));
        }

        $this->set(compact('report', 'question'));
        $this->set('_serialize', ['report']);

        return null;
    }
}
