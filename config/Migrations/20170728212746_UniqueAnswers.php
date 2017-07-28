<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class UniqueAnswers extends AbstractMigration
{
    public function change(): void
    {
        $this->table('answers')
            ->addIndex(['user_id', 'question_id'], ['unique' => true, 'name' => 'UNQ_USER_QUESTION'])
            ->update();
    }
}
