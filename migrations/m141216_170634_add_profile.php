<?php

use yii\db\Schema;
use app\migrations\Migration;

class m141216_170634_add_profile extends Migration
{
    public function up(){
        $this->createTable($this->profile, [
            'user_id'        => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'first_name'     => Schema::TYPE_STRING . '(100)',
            'last_name'      => Schema::TYPE_STRING . '(100)',
            'avatar'         => Schema::TYPE_STRING . '(255)',
            'city'           => Schema::TYPE_STRING . '(70)',
            'address'        => Schema::TYPE_STRING . '(150)',
            'phone'          => Schema::TYPE_STRING . '(150)'
        ], $this->tableOptions);

        $this->addForeignKey('fk_user_id_profile', $this->profile, 'user_id', $this->user, 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable( $this->profile );
    }
}
