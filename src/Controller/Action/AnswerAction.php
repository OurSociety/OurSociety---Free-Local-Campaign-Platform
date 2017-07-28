<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Action;

use Cake\Controller\Controller;
use Cake\ORM\Query;
use Cake\Utility\Hash;
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

        // If user skips all questions, data will be empty but treat it as a successful case.
        if (empty($data)) {
            return $this->_success();
        }

        // Remove all questions that have been answered already, we don't show them to users but it's possible for the
        // server to receive the same answers twice if client refreshes page while there are validation errors.
        $answeredQuestionIds = $table->Answers->find()
            ->where([
                'user_id' => $this->_controller()->Auth->user()->id,
                'question_id IN' => Hash::extract($data, '{n}.id'),
            ])
            ->all()
            ->extract('question_id')
            ->toArray();

        /** @var array $data */
        $data = collection($data)
            ->filter(function (array $questionData) use ($answeredQuestionIds) {
                return !in_array($questionData['id'], $answeredQuestionIds, true);
            })
            ->toArray();

        // Create entities from remaining unanswered questions in data.
        $questions = $table->patchEntities(
            $table->find()->where(['id IN' => Hash::extract($data, '{n}.id')])->all()->toArray(),
            $data,
            ['associated' => ['Answers']]
        );

        // The order of questions on the page is important, since patchEntities resets all the keys we use this method
        // to create a new array containing any unsaved entities with their original/expected indexes.
        $getIndex = function (Question $question) use ($data) : int {
            foreach ($data as $index => $row) {
                if ($row['id'] === $question->id) {
                    return $index;
                }
            }

            throw new \RuntimeException('Question indexing error.');
        };

        // Create empty array to catch unsaved answers.
        $errors = [];
        foreach ($questions as $index => $question) {
            // Save the answers we can and forget about them, they won't be shown to the user again.
            $saved = $table->save($question);
            if ($saved === false) {
                // Store the answers we can't save, with their index intact. This way question #3 will be redisplayed
                // as question #3 and the inputs will automatically be populated with their previous values.
                $errors[$getIndex($question)] = $question;
            }
        }
        // Not sure why yet, but the order can end up with question #4 before question #3 - a simple key sort fixes it.
        ksort($errors, SORT_NUMERIC);

        // If there are no errors, take the user away.
        if (count($errors) === 0) {
            return $this->_success();
        }

        // Otherwise, show them the page again with the failed entities at the same indexes as before.
        // All skipped questions that were not sent to us, or saved questions that were sent will not be displayed.
        return $this->_error($errors);
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
