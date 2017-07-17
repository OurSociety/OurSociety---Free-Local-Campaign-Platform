<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller\Citizen;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Text;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\Question;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\QuestionsTable;
use OurSociety\Test\Fixture\UsersFixture;
use OurSociety\TestSuite\IntegrationTestCase;

class QuestionsControllerTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        /** @var QuestionsTable $table */
        $table = TableRegistry::get('Questions');

        $this->auth(UsersFixture::EMAIL_CITIZEN);
        $this->get(['_name' => 'citizen:questions']);
        $this->assertResponseOk();

        /** @var User $user */
        $user = $this->_session['Auth']['User'];
        $number = 1;
        $data = $table->getBatch()->map(function (Question $question) use ($user, &$number) {
            $this->assertResponseContains(sprintf('Question #%d', $number++));
            $this->assertResponseContains($question->question);

            return [
                'id' => $question->id,
                'answers' => [
                    [
                        'id' => Text::uuid(), // TODO: This field is required.
                        'question_id' => $question->id,
                        'user_id' => $user->id,
                        'answer' => array_rand(Answer::ANSWERS_SCALE),
                    ]
                ],
            ];
        })->toArray();

        $this->post(['_name' => 'citizen:questions'], $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['_name' => 'citizen:dashboard']);

        $answers = TableRegistry::get('Answers')->find()->where([
            'user_id' => $user->id,
            'question_id IN' => Hash::extract($data, '{n}.id'),
        ]);
        self::assertEquals(10, $answers->count());
    }
}
