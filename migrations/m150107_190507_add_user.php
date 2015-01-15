<?php

use yii\db\Schema;
use app\migrations\Migration;

class m150107_190507_add_user extends Migration
{
    public function up(){
        $this->createTable($this->user, [
            'id'                   => Schema::TYPE_PK,
            'username'             => Schema::TYPE_STRING . '(25) NOT NULL',
            'email'                => Schema::TYPE_STRING . '(255) NOT NULL',
            'password'             => Schema::TYPE_STRING . '(60) NOT NULL',
            'aktiv_key'            => Schema::TYPE_STRING . '(32)',
            'role'                 => Schema::TYPE_STRING . '(20) NOT NULL',
            'created_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'lastvisit_at'         => Schema::TYPE_INTEGER,
            'status'               => Schema::TYPE_INTEGER . '(1)',
        ], $this->tableOptions);

        $this->createIndex('k_username_user', $this->user, 'username', true);
        $this->createIndex('k_email_user', $this->user, 'email', true);

    }

    public function down()
    {
        $this->dropTable( $this->user );
    }
}
