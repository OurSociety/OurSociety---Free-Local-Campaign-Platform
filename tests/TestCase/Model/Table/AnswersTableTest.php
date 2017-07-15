<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Table\AnswersTable;
use OurSociety\TestSuite\Traits\FixturesTrait;

/**
 * OurSociety\Model\Table\AnswersTable Test Case
 */
class AnswersTableTest extends AppTableTest
{
    use FixturesTrait;

    public $autoFixtures = false;

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->loadFixtures('Answers', 'Questions', 'Users');

        /** @var AnswersTable $table */
        $table = $this->table;

        $answer = $table->find()->firstOrFail();

        // Test display field
        self::assertEquals(
            Answer::ANSWERS_SCALE[Answer::ANSWER_STRONGLY_AGREE], // 'Strongly Agree'
            $answer->{$table->getDisplayField()} // `$answer->name`
        );

        // Test CounterCache(s)
        $user = $table->Users->find()->firstOrFail();
        $answerCount = $table->Users->get($user->id)->answer_count;
        $table->saveOrFail($table->newEntity([
            'id' => Text::uuid(), // TODO: Fix 'This field is required'
            'question_id' => $table->Questions->find()->firstOrFail()->id,
            'user_id' => $user->id,
            'answer' => Answer::ANSWER_STRONGLY_AGREE,
        ]));
        self::assertEquals($answerCount + 1, $table->Users->get($user->id)->answer_count);
        // TODO //'Questions' => ['citizen_answer_count', 'politician_answer_count'],

        // Test relation(s)
        /** @var Answer $answer */
        $answer = $table->find()->contain(['Questions', 'Users'])->firstOrFail();
        self::assertEquals($answer->question_id, $answer->question->id);
        self::assertEquals($answer->user_id, $answer->user->id);
    }

    public function provideValidationDefault(): array
    {
        $this->markTestIncomplete();
        return parent::provideValidationDefault();
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
        parent::testBuildRules();
    }
}
