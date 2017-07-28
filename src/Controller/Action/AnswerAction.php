<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Action;

use Cake\Controller\Controller;
use Cake\ORM\Query;
use OurSociety\Controller\AppController;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Table\QuestionsTable;
use Psr\Http\Message\ResponseInterface as Response;
use Crud\Action\BaseAction;
use Crud\Traits\FindMethodTrait;
use Crud\Traits\RedirectTrait;
use Crud\Traits\SaveMethodTrait;

class AnswerAction extends BaseAction
{
    use FindMethodTrait;
    use SaveMethodTrait;
    use RedirectTrait;

    public function __construct(Controller $Controller, $config = [])
    {
        $this->_defaultConfig = [];

        parent::__construct($Controller, $config);
    }

    public function _get(): void
    {
        if ($this->getConfig('redirectUrl') === null) {
            throw new \InvalidArgumentException('Config key "redirectUrl" not set.');
        }

        $controller = $this->_controller();
        $table = $this->_table();

        $user = $controller->Auth->user();
        $query = $table->find('batch', ['user' => $user]);
        $questions = $controller->paginate($query)->toArray();

        $controller->set(['questions' => $questions]);
    }

    protected function _post(): ?Response
    {
        return $this->_put();
    }

    protected function _patch(): ?Response
    {
        return $this->_put();
    }

    protected function _put(): ?Response
    {
        /** @var QuestionsTable $table */
        $table = $this->_table();
        $request = $this->_request();
        $data = $request->getData();

        if (empty($data)) {
            return $this->_success();
        }

        $questionsOrSaved = $table->saveAnswers($data);

        if ($questionsOrSaved === true) {
            return $this->_success();
        }

        return $this->_error($questionsOrSaved);
    }

    public function _success(): ?Response
    {
        /** @var AppController $controller */
        $controller = $this->_controller();

        $controller->Auth->refreshSession();
        $controller->Flash->success('Your answers have been saved. Keep answering to improve your score!');

        return $controller->redirect($this->getConfig('redirectUrl'));
    }

    public function _error(array $questions): ?Response
    {
        $controller = $this->_controller();

        $questionsForView = collection($questions)->map(function (Question $question) {
            /** @var QuestionsTable $table */
            $table = $this->_table();
            $question->category = $table->Categories->find()->matching('Questions', function (Query $query) use ($question) {
                return $query->where(['Questions.id' => $question->id]);
            })->firstOrFail();

            return $question;
        })->toArray();

        $controller->set(['questions' => $questionsForView]);
        $controller->Flash->error('Please fix the incomplete answers below, or mark those questions to be answered later.');

        return null;
    }
}
