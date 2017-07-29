<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\Model\Table;

use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Table\AnswersTable;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\Traits\FixturesTrait;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * OurSociety\Model\Table\AnswersTable Test Case
 */
class AnswersTableTest extends AppTableTest
{
    use FixturesTrait;
    use MatchesSnapshots;

    /**
     * @var AnswersTable
     */
    public $table;

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        /** @var AnswersTable $table */
        $table = $this->table;

        $answer = $table->find()->firstOrFail();

        // Test display field
        self::assertEquals(
            Answer::ANSWERS_SCALE[Answer::ANSWER_NEUTRAL], // 'No Opinion'
            $answer->{$table->getDisplayField()} // `$answer->name`
        );

        // Test CounterCache(s)
        $user = $table->Users->get(UsersFixture::CITIZEN_ID);
        $answerCount = $user->answer_count;
        $entity = $table->newEntity([
            'question_id' => $table->Questions->find()->firstOrFail()->id,
            'user_id' => $user->id,
            'answer' => Answer::ANSWER_STRONGLY_AGREE,
            'importance' => Answer::IMPORTANCE_VERY,
        ]);
        $table->save($entity);

        self::assertEmpty($entity->getErrors());
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

    public function testAfterSave(): void
    {
        $getCitizenMatches = function (): array {
            return $this->table->Users->ValueMatches->find()
                ->where([
                    'citizen_id' => UsersFixture::CITIZEN_ID
                ])
                ->enableHydration(false)
                ->all()
                ->toArray();
        };

        $this->assertMatchesSnapshot($getCitizenMatches());

        $entity = $this->table->newEntity([
            'question_id' => $this->table->Questions->find()->firstOrFail()->id,
            'user_id' => UsersFixture::CITIZEN_ID,
            'answer' => Answer::ANSWER_STRONGLY_AGREE,
            'importance' => Answer::IMPORTANCE_VERY,
        ]);
        mt_srand(SEED);
        $this->table->save($entity);
        mt_srand();

        $this->assertMatchesSnapshot($getCitizenMatches());
    }
}
