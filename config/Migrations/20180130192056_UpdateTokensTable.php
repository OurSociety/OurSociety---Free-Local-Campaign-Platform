<?php
use Migrations\AbstractMigration;

class UpdateTokensTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('tokens');
        $table->changeColumn('lookup', 'string', ['limit' => 255]);
        $table->changeColumn('hash', 'string', ['limit' => 255]);
    }

    public function down()
    {

    }
}
