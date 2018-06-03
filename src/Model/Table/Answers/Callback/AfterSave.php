<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Answers\Callback;

use ArrayObject;
use Cake\Database\Connection;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Association;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use OurSociety\Model\Entity\Answer;
use OurSociety\Model\Entity\CosineSimilarity;
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

        $CATcondition['slug IS'] = $question->category->slug;
        $CATtable = TableRegistry::get('categories');
        $category = $CATtable->find()->where($CATcondition)->first()->id;

        $this->updateValueMatchesAll($userFrom, $usersTo, $question);
        $this->updateValueMatchesCategory($userFrom, $usersTo, $question, $category);
    }
    public function updateValueMatchesAll($userFrom, $usersTo, $question): void
    {
        $query = <<<SQL
SELECT *
FROM answers
WHERE user_id = ?
ORDER BY question_id
SQL;
        $connection = $this->getConnection();
        $statement = $connection->execute($query, [$userFrom->id]);
        $userFromAnsers = $statement->fetchAll('assoc');
        $statement->closeCursor();
        foreach ($usersTo as $userTo) {
            $query = <<<SQL
SELECT *
FROM answers
WHERE user_id = ?
ORDER BY question_id
SQL;
            $connection = $this->getConnection();
            $statement = $connection->execute($query, [$userTo->id]);
            $userToAnsers = $statement->fetchAll('assoc');
            $statement->closeCursor();

            $needleelems = [];
            $targetelems = [];

            for ($qno=0; $qno < count($userFromAnsers); $qno++) {
                $qnoid = array_values($userFromAnsers)[$qno]["question_id"];
                array_push($needleelems,$qnoid);
            }

            for ($qno=0; $qno < count($userToAnsers); $qno++) {
                $qnoid = array_values($userToAnsers)[$qno]["question_id"];
                array_push($targetelems,$qnoid);
            }

            foreach ($needleelems as $i => $needle) {
                if (!in_array($needle, $targetelems)) {
                    unset($userFromAnsers[$i]);
                }
            }
            foreach ($targetelems as $i => $needle) {
                if (!in_array($needle, $needleelems)) {
                    unset($userToAnsers[$i]);
                }
            }

            if (count($userFromAnsers) > 0 && count($userToAnsers) > 0) {
                $sampleSize = min(count($userFromAnsers), count($userToAnsers));
                $cs = new CosineSimilarity();
                $trueMatchPercentage = $matchPercentage = ($cs->similarity($userFromAnsers, $userToAnsers) + 1) * 50;
                $errorPercentage = 0;
            } else {
                $trueMatchPercentage = $matchPercentage = null;
                $errorPercentage = 100;
            }

            $data = [];
            $dataDefault = [
                'citizen_id' => $userFrom->isPolitician() ? $userTo->id : $userFrom->id,
                'politician_id' => $userFrom->isPolitician() ? $userFrom->id : $userTo->id,
            ];
            $data[] = $dataDefault + [
                'category_id' => $question->category_id,
            ];
            $conditions = ['or' => []];
            foreach ($data as $condition) {
                if ($condition['category_id'] === null) {
                    unset($condition['category_id']);
                    $condition['category_id IS'] = null;
                }
                $conditions['or'][] = $condition;
            }
            $outdatedMatch = $this->Users->ValueMatches->find()->where($conditions)->first();
            foreach ($data as &$datum) {
                if (
                    $datum['citizen_id'] === $outdatedMatch->citizen_id &&
                    $datum['politician_id'] === $outdatedMatch->politician_id &&
                    $datum['category_id'] === $outdatedMatch->category_id
                ) {
                    $datum['id'] = $outdatedMatch->id;
                }
            }
            $datum += [
                'true_match_percentage' => $trueMatchPercentage,
                'match_percentage' => $matchPercentage,
                'error_percentage' => $errorPercentage,
                'sample_size' => $sampleSize,
            ];
            $updatedMatches = [];
            $updatedMatch = $this->Users->ValueMatches->patchEntities($outdatedMatch, $data);
            $this->Users->ValueMatches->save($updatedMatch[0]);
        }
    }
    public function updateValueMatchesCategory($userFrom, $usersTo, $question, $category): void
    {
        $query = <<<SQL
SELECT *
FROM answers
LEFT JOIN questions ON answers.question_id = questions.id
WHERE user_id = ?
AND questions.category_id = ?
ORDER BY question_id
SQL;
        $connection = $this->getConnection();
        $statement = $connection->execute($query, [$userFrom->id, $category]);
        $userFromAnsers = $statement->fetchAll('assoc');
        $statement->closeCursor();
        foreach ($usersTo as $userTo) {
            $query = <<<SQL
SELECT *
FROM answers
LEFT JOIN questions ON answers.question_id = questions.id
WHERE user_id = ?
AND questions.category_id = ?
ORDER BY question_id
SQL;
            $connection = $this->getConnection();
            $statement = $connection->execute($query, [$userTo->id, $category]);
            $userToAnsers = $statement->fetchAll('assoc');
            $statement->closeCursor();

            $needleelems = [];
            $targetelems = [];

            for ($qno=0; $qno < count($userFromAnsers); $qno++) {
                $qnoid = array_values($userFromAnsers)[$qno]["question_id"];
                array_push($needleelems,$qnoid);
            }

            for ($qno=0; $qno < count($userToAnsers); $qno++) {
                $qnoid = array_values($userToAnsers)[$qno]["question_id"];
                array_push($targetelems,$qnoid);
            }

            foreach ($needleelems as $i => $needle) {
                if (!in_array($needle, $targetelems)) {
                    unset($userFromAnsers[$i]);
                }
            }
            foreach ($targetelems as $i => $needle) {
                if (!in_array($needle, $needleelems)) {
                    unset($userToAnsers[$i]);
                }
            }

            if (count($userFromAnsers) > 0 && count($userToAnsers) > 0) {
                $sampleSize = min(count($userFromAnsers), count($userToAnsers));
                $cs = new CosineSimilarity();
                $trueMatchPercentage = $matchPercentage = ($cs->similarity($userFromAnsers, $userToAnsers) + 1) * 50;
                $errorPercentage = 0;
            } else {
                $trueMatchPercentage = $matchPercentage = null;
                $errorPercentage = 100;
            }

            $data = [];
            $dataDefault = [
                'citizen_id' => $userFrom->isPolitician() ? $userTo->id : $userFrom->id,
                'politician_id' => $userFrom->isPolitician() ? $userFrom->id : $userTo->id,
            ];
            $data[] = $dataDefault + [
                'category_id' => $category,
            ];
            $conditions = ['or' => []];
            foreach ($data as $condition) {
                if ($condition['category_id'] === null) {
                    unset($condition['category_id']);
                    $condition['category_id IS'] = null;
                }
                $conditions['or'][] = $condition;
            }
            $outdatedMatch = $this->Users->ValueMatches->find()->where($conditions)->first();
            foreach ($data as &$datum) {
                if (
                    $datum['citizen_id'] === $outdatedMatch->citizen_id &&
                    $datum['politician_id'] === $outdatedMatch->politician_id &&
                    $datum['category_id'] === $outdatedMatch->category_id
                ) {
                    $datum['id'] = $outdatedMatch->id;
                }
            }
            $datum += [
                'true_match_percentage' => $trueMatchPercentage,
                'match_percentage' => $matchPercentage,
                'error_percentage' => $errorPercentage,
                'sample_size' => $sampleSize,
            ];
            $updatedMatches = [];
            $updatedMatch = $this->Users->ValueMatches->patchEntities($outdatedMatch, $data);
            $this->Users->ValueMatches->save($updatedMatch[0]);
        }
    }
}
