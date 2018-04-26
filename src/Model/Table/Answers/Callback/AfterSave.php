<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Answers\Callback;

use ArrayObject;
use Cake\Database\Connection;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Association;
use Cake\ORM\Query;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Entity\ValueMatch;
use OurSociety\Model\Table\QuestionsTable;
use OurSociety\Model\Table\UsersTable;

/**
 * Trait AfterSave
 *
 * @property QuestionsTable|Association\BelongsTo $Questions
 * @property UsersTable|Association\BelongsTo $Users
 */
trait AfterSave
{
    public function afterSave(Event $event, Answer $answer, ArrayObject $options): void
    {
        $this->updateUser($answer);
        $this->updateValueMatches($answer);
    }

    public function updateUser(Answer $answer): void
    {
        $user = $answer->user ?? $this->Users->get($answer->user_id);

        $remainingQuestions = $this->Questions->find('batch', ['user' => $user])->count();

        if ($remainingQuestions === 0) {
            $user->levelUp();
        }
    }

    protected function updateValueMatches(Answer $answer): void
    {
        $userFrom = $answer->user ?? $this->Users->get($answer->user_id);
        $question = $answer->question ?? $this->Questions->get($answer->question_id);

        /** @var User[] $usersTo */
        $usersTo = $this->Users->find()->where([
            'answer_count >' => 0,
            'role' => $userFrom->isPolitician() ? User::ROLE_CITIZEN : User::ROLE_POLITICIAN,
        ])->all();

        $data = [];
        foreach ($usersTo as $userTo) {
            $dataDefault = [
                'citizen_id' => $userFrom->isPolitician() ? $userTo->id : $userFrom->id,
                'politician_id' => $userFrom->isPolitician() ? $userFrom->id : $userTo->id,
            ];
            $data[] = $dataDefault + [
                'category_id' => $question->category_id,
            ];
        }

        $conditions = ['or' => []];
        foreach ($data as $condition) {
            if ($condition['category_id'] === null) {
                unset($condition['category_id']);
                $condition['category_id IS'] = null;
            }
            $conditions['or'][] = $condition;
        }
        /** @var ValueMatch[] $outdatedMatches */
        $outdatedMatches = $this->Users->ValueMatches->find()->where($conditions)->all();

         foreach ($outdatedMatches as $outdatedMatch) {
            foreach ($data as &$datum) {
                if (
                    $datum['citizen_id'] === $outdatedMatch->citizen_id &&
                    $datum['politician_id'] === $outdatedMatch->politician_id &&
                    $datum['category_id'] === $outdatedMatch->category_id
                ) {
                    $datum['id'] = $outdatedMatch->id;
                }
            }
            unset($datum);
        }

        foreach ($data as &$datum) {
            /** @var Query $query */
            $query = $this->find();
            $citizenQuestions = $query->where(['user_id' => $datum['citizen_id']])->all()->toArray();
            $politicianQuestions = $query->where(['user_id' => $datum['politician_id']])->all()->toArray();
            $this->calculateMatch($citizenQuestions, $politicianQuestions);
            }
            

        unset($datum);

        $updatedMatches = $this->Users->ValueMatches->patchEntities($outdatedMatches, $data);

        $this->Users->ValueMatches->saveMany($updatedMatches);
    }
    private function calculateMatch($citizenQuestions, $politicianQuestions){
        foreach ($citizenQuestions as $politicianQuestion){
            foreach ($politicianQuestions as $politicianQuestion){
                //calc
            }
        }
    }
}
