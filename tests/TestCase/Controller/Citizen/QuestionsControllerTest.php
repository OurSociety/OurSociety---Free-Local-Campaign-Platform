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
        $batchLimit = 10;

        /** @var QuestionsTable $table */
        $table = TableRegistry::get('Questions');

        $this->auth(UsersFixture::CITIZEN_EMAIL);
        $this->get(['_name' => 'citizen:questions', '?' => ['limit' => $batchLimit]]);
        $this->assertResponseOk();

        /** @var User $user */
        $user = $this->_session['Auth']['User'];
        $number = 1;
        $mapFormData = function (Question $question) use ($user, &$number) {
            $this->assertResponseContains(sprintf('Question #%d', $number++));
            $this->assertResponseContains($question->question);

            $answer = [
                'question_id' => $question->id,
                'user_id' => $user->id,
                'answer' => array_rand(Answer::ANSWERS_SCALE),
                'importance' => array_rand(Answer::IMPORTANCE),
            ];

            return ['id' => $question->id, 'answers' => [$answer]];
        };

        $data = $table->find('batch', ['user' => $user])
            ->limit($batchLimit)
            ->map($mapFormData)
            ->toArray();

        $this->post(['_name' => 'citizen:questions'], $data);
        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect(['_name' => 'citizen:dashboard']);

        $answers = TableRegistry::get('Answers')->find()->where([
            'user_id' => $user->id,
            'question_id IN' => Hash::extract($data, '{n}.id'),
        ]);
        self::assertEquals($batchLimit, $answers->count());
    }
}
