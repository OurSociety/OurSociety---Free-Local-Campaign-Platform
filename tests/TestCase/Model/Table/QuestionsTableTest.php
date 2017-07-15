<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Table\QuestionsTable;
use OurSociety\Model\Table\UsersTable;
use OurSociety\Test\Fixture\UsersFixture;

/**
 * OurSociety\Model\Table\QuestionsTable Test Case
 *
 */
class QuestionsTableTest extends AppTableTest
{
    /**
     * {@inheritdoc}
     *
     * @return QuestionsTable
     */
    protected static function instance(): Table
    {
        return QuestionsTable::instance();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * {@inheritdoc}
     */
    public function provideValidationDefault(): array
    {
        return array_merge([
            // TODO: Validate rest of fields.
        ], parent::provideValidationDefault());
    }

    public function testSaveAnswers(): void
    {
        /** @var QuestionsTable $table */
        $table = $this->table;

        $user = UsersTable::instance()->find()->where(['email' => UsersFixture::EMAIL_CITIZEN])->firstOrFail();
        $data = $table->getBatch()->map(function (Question $question) use ($user) {
            return [
                'id' => $question->id,
                'answers' => [
                    [
                        'id' => Text::uuid(),
                        'question_id' => $question->id,
                        'user_id' => $user->id,
                        'answer' => array_rand(Answer::ANSWERS_SCALE),
                    ]
                ],
            ];
        });

        $count = $table->Answers->find()->count();
        $table->saveAnswers($data->toArray());

        self::assertEquals($count + 10, $table->Answers->find()->count());
    }
}
