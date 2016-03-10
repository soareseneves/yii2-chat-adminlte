<?php

/**
 * @link https://github.com/soareseneves/yii2-chat-adminlte
 * @copyright Copyright (c) 2014 Andy fitria 
 * @license MIT
 */

namespace soareseneves\chat;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Andy Fitria <sintret@gmail.com>
 */
class ChatJs extends AssetBundle {

    public $sourcePath = '@vendor/soareseneves/yii2-chat-adminlte/assets';
    public $js = [
        'js/chat.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
