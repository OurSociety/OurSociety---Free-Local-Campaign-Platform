<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Common;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\View\Cell;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\Question;

/**
 * Question cell
 */
class QuestionCell extends Cell
{
    public function __construct(
        ServerRequest $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $cellOptions = []
    ) {
        $this->_validCellOptions = [];

        parent::__construct($request, $response, $eventManager, $cellOptions);
    }

    /**
     * Display a single question.
     *
     * @param Question $question
     * @param int $number
     * @return void
     */
    public function display(Question $question, int $number = null, Answer $answer = null): void
    {
        $this->set([
            'question' => $question,
            'number' => $number,
            'answer' => $answer,
            'identity' => $this->request->getAttribute('identity')->getOriginalData(),
        ]);
    }

    /**
     * Display a batch of questions.
     *
     * @param Question[] $questions
     * @return void
     */
    public function batch(array $questions): void
    {
        $this->set([
            'questions' => $questions,
        ]);
    }
}
