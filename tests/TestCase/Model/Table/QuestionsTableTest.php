<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Entity\User;
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

    /**
     * @dataProvider provideSaveAnswers
     * @param string $expected The expected case.
     * @param callable $setAnswerAndImportance The callable that sets 'answer' and 'importance' fields.
     */
    public function testSaveAnswers(string $expected, callable $setAnswerAndImportance): void
    {
        $this->markTestIncomplete('Method removed and logic moved to AnswerAction - test logic should be moved too.');
        return;
        /** @var QuestionsTable $table */
        $table = $this->table;

        /** @var User $user */
        $user = UsersTable::instance()->get(UsersFixture::CITIZEN_ID);

        $formEntitiesToModelData = function (Question $question): array {
            return [
                'id' => $question->id,
                'answers' => [0 => ['id' => Text::uuid(), 'question_id' => $question->id]],
            ];
        };

        $addUserId = function (array $questionRow) use ($user): array {
            $questionRow['answers'][0]['user_id'] = $user->id;

            return $questionRow;
        };

        $batchSize = 2;
        $data = $table->find('batch', ['user' => $user])
            ->limit($batchSize)
            ->map($formEntitiesToModelData)
            ->map($addUserId)
            ->map($setAnswerAndImportance)
            ->toArray();

        $originalRowCount = $table->Answers->find()->count();
        $questionsOrSaved = $table->saveAnswers($data);

        switch ($expected) {
            case 'success':
                self::assertTrue($questionsOrSaved);
                self::assertEquals($originalRowCount + $batchSize, $table->Answers->find()->count());
                break;
            case 'error':
                self::assertNotTrue($questionsOrSaved);
                self::assertInternalType('array', $questionsOrSaved);

                $filterRowsWithoutErrors = function (Question $question): bool {
                    return count($question->getErrors()) > 0 || count($question->answers[0]->getErrors()) > 0;
                };

                $extractErrors = function (Question $question): array {
                    return $question->getErrors() + $question->answers[0]->getErrors();
                };

                $errors = collection($questionsOrSaved)
                    ->filter($filterRowsWithoutErrors)
                    ->map($extractErrors)
                    ->toArray();

                self::assertNotEmpty($errors);
                self::assertEquals($originalRowCount, $table->Answers->find()->count());
                break;
        }
    }

    public function provideSaveAnswers(): array
    {
        return [
            'success (scale)' => [
                'expected' => 'success',
                'setAnswerAndImportance' => function (array $questionRow): array {
                    $questionRow['answers'][0]['answer'] = array_rand(Answer::ANSWERS_SCALE);
                    $questionRow['answers'][0]['importance'] = array_rand(Answer::IMPORTANCE);

                    return $questionRow;
                }
            ],
            'success (yes/no)' => [
                'expected' => 'success',
                'setAnswerAndImportance' => function (array $questionRow): array {
                    $questionRow['answers'][0]['answer'] = array_rand(Answer::ANSWERS_BOOL);
                    $questionRow['answers'][0]['importance'] = array_rand(Answer::IMPORTANCE);

                    return $questionRow;
                }
            ],
            'error (missing importance)' => [
                'expected' => 'error',
                'setAnswerAndImportance' => function (array $questionRow): array {
                    $questionRow['answers'][0]['answer'] = array_rand(Answer::ANSWERS_SCALE);

                    return $questionRow;
                }
            ],
            'error (missing answer)' => [
                'expected' => 'error',
                'setAnswerAndImportance' => function (array $questionRow): array {
                    $questionRow['answers'][0]['importance'] = array_rand(Answer::IMPORTANCE);

                    return $questionRow;
                }
            ],
        ];
    }
}
