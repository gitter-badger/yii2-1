<?php

use yii\db\Schema;
use app\migrations\Migration;

class m150115_222542_add_fields_to_user extends Migration
{
    public function up()
    {
        $this->addColumn($this->user, 'auth_key', Schema::TYPE_STRING . '(32) NOT NULL AFTER email');
        $this->addColumn($this->user, 'email_confirm_token', Schema::TYPE_STRING . ' NULL DEFAULT NULL AFTER auth_key');
        $this->addColumn($this->user, 'password_hash', Schema::TYPE_STRING . ' NOT NULL AFTER email');
        $this->addColumn($this->user, 'password_reset_token', Schema::TYPE_STRING . ' NULL DEFAULT NULL AFTER password_hash');
        $this->dropColumn($this->user, 'password');
        $this->dropColumn($this->user, 'aktiv_key');
    }

    public function down()
    {
        $this->dropColumn($this->user, 'auth_key');
        $this->dropColumn($this->user, 'email_confirm_token');
        $this->dropColumn($this->user, 'password_hash');
        $this->dropColumn($this->user, 'password_reset_token');
    }
}
