<?php

namespace app\migrations;

class Migration extends \yii\db\Migration
{
    protected $tableOptions;

    // tables
    protected $user;
    protected $profile;
    protected $cache;

    public function init() {
        parent::init();
        $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->cache = '{{%cache}}';
        $this->user = '{{%user}}';
        $this->profile = '{{%profile}}';

    }
}