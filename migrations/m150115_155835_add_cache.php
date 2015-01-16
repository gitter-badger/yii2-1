<?php

use yii\db\Schema;
use app\migrations\Migration;

class m150115_155835_add_cache extends Migration
{
    public function up()
    {
        $this->createTable($this->cache, [
            'id'        => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'expire'     => Schema::TYPE_INTEGER . '(11)',
            'data'      => 'BLOB'
        ], $this->tableOptions);

    }

    public function down()
    {
        $this->dropTable( $this->cache );
    }
}
