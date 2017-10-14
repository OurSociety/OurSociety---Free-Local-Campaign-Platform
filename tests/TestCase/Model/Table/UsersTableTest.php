<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Model\Table;

use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\Traits\FixturesTrait;

/**
 * OurSociety\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends AppTableTest
{
    use FixturesTrait;

    public function testSave(): void
    {
        /** @var User $user */
        $user = $this->table->saveOrFail($this->table->newEntity([
            'email' => 'test@example.com',
            'zip' => '07501',
            'password' => 'password',
            'name' => 'Test User',
        ]));

        self::assertEquals('test@example.com', $user->email);
        self::assertEquals('07501', $user->zip);
        self::assertNotEquals('password', $user->password);
        self::assertEquals('Test User', $user->name);
    }

    /**
     * {@inheritdoc}
     */
    public function provideValidationDefault(): array
    {
        return array_merge([
            'success (role is admin)' => [
                'field' => 'role',
                'value' => 'admin',
            ],
            'success (role is citizen)' => [
                'field' => 'role',
                'value' => 'citizen',
            ],
            'success (role is politician)' => [
                'field' => 'role',
                'value' => 'politician',
            ],
            'error (role is NOT in list)' => [
                'field' => 'role',
                'value' => 'unknown',
                'error' => ['inList' => 'The only valid roles are "admin", "citizen", "politician".'],
            ],
            'success (zip is valid)' => [
                'field' => 'zip',
                'value' => '01234',
            ],
            'success (zip is extended valid)' => [
                'field' => 'zip',
                'value' => '01234-5678',
            ],
            'error (zip is NOT valid)' => [
                'field' => 'zip',
                'value' => '1234',
                'error' => ['zip' => 'Please enter a valid ZIP code (e.g. 12345 or 12345-6789)'],
            ],
            // TODO: Validate rest of fields.
        ], parent::provideValidationDefault());
    }

    /**
     * {@inheritdoc}
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete();
        parent::testBuildRules(); // TODO: Implement.
    }

    /**
     * Test findAuth method
     *
     * @return void
     */
    public function testFindAuth(): void
    {
        $expected = $this->table->query();
        $actual = $this->table->find('auth');

        self::assertEquals($expected, $actual);
    }

    /**
     * @dataProvider provideGetValueMatch
     * @param string $citizenId The ID of the citizen to find match for.
     * @param int $expectedSampleSize The expected sample size.
     * @param float $expectedMatch Expected match percentage with margin of error accounted for.
     * @return void
     */
    public function testGetValueMatch(string $citizenId, int $expectedSampleSize, float $expectedMatch): void
    {
        /** @var UsersTable $usersTable */
        $usersTable = $this->table;
        $citizen = $usersTable->get($citizenId);
        $politician = $usersTable->get(UsersFixture::POLITICIAN_ID);

        $sampleSize = $usersTable->Answers->find()
            ->where(['Answers.user_id' => $citizenId])
            ->count();

        self::assertEquals($expectedSampleSize, $sampleSize);

        $match = $usersTable->getValueMatch($citizen, $politician);

        self::assertEquals($expectedMatch, $match);

        return;




        $answersTable = $usersTable->Answers;
        $questionsTable = $answersTable->Questions;

        self::assertEquals(20, $answersTable->find()->count());

        $users = $usersTable->find()
            ->select(['id'])
            ->where(['Users.email IN' => [UsersFixture::CITIZEN_EMAIL, UsersFixture::POLITICIAN_EMAIL]])
            ->all();

        $questions = $questionsTable->find('batch', ['user' => $users->first()])
            ->limit($citizenId)
            ->all();

        $data = [];
        /** @var Question $question */
        foreach ($questions as $question) {
            foreach ($users as $user) {
                $data[] = [
                    'user_id' => $user->id,
                    'question_id' => $question->id,
                    'answer' => $question->type === 'scale'
                        ? array_rand(Answer::ANSWERS_SCALE)
                        : array_rand(Answer::ANSWERS_BOOL),
                    'importance' => array_rand(Answer::IMPORTANCE),
                ];
            }
        }

        $entities = $answersTable->newEntities($data);

        $answersTable->getConnection()->transactional(function () use ($answersTable, $entities) {
            foreach ($entities as $entity) {
                $answersTable->save($entity, ['atomic' => false]);
            }
        });

        self::assertEquals($citizenId * $users->count(), $answersTable->find()->count());

        $match = $usersTable->getValueMatch($users->first(), $users->last());

        self::assertEquals($match, $expectedMatch);
    }

    public function provideGetValueMatch(): array
    {
        return [
            'success (exact match, sample size 1, value match 0%)' => [
                'citizenId' => UsersFixture::CITIZEN_1_ID,
                'expectedSampleSize' => 1,
                'expectedTrueMatch' => 0.0, // 1 / 1 = 1.0 => 100% match - 100% margin of error = 0% expected match
            ],
            'success (exact match, sample size 5, value match 80%)' => [
                'citizenId' => UsersFixture::CITIZEN_2_ID,
                'expectedSampleSize' => 10,
                'expectedTrueMatch' => 90.0, // 1/10 = 0.1 => 100% match - 10% margin of error = 90% expected match
            ],
            'success (exact match, sample size 50, value match 98%)' => [
                'citizenId' =>  UsersFixture::CITIZEN_3_ID,
                'expectedSampleSize' => 50,
                'expectedTrueMatch' => 98.0, // 1/50 = 0.02 => 100% match - 2% margin of error = 98% expected match
            ],
        ];
    }
}
