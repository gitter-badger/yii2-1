<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init(){
        parent::init();
        $this->js[] = YII_DEBUG ? 'dist/js/main.js' : 'dist/js/main.min.js';
        $this->css[] = YII_DEBUG ? 'dist/css/main.css' : 'dist/css/main.min.css';
    }

}
