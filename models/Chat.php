<?php

namespace soareseneves\chat\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $message
 * @property integer $userId
 * @property string $updateDate
 */
class Chat extends \yii\db\ActiveRecord {

    public $userModel;
    public $userField;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message'], 'required'],
            [['userId'], 'integer'],
            [['updateDate', 'message'], 'safe']
        ];
    }

    public function getUser() {
        if (isset($this->userModel))
            return $this->hasOne($this->userModel, ['id' => 'userId']);
        else
            return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'userId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'userId' => 'User',
            'updateDate' => 'Update Date',
        ];
    }

    public function beforeSave($insert) {
        $this->userId = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    public static function records($num = 1) {
        $query = static::find()->orderBy('id desc');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '8']);

        //die('page: ' . $num);
        if ($num > 1){
            $pages->setPage($num);
            $offset = 1;
            $limit = $pages->limit * $num;
        } else {
            $offset = $pages->offset;
            $limit = $pages->limit;
        }

        $models = $query->offset($offset)
            ->limit($limit)
            ->all();


        $result = ['data' => $models, 'pages' => $pages];

        return $result;
    }

    public function data($num = 1) {
        $userField = $this->userField;
        $output = '';
        $data = Chat::records($num);
        $pages = $data['pages'];
        $models = $data['data'];
        if ($models)
            foreach ($models as $model) {
                if (isset($model->user->$userField)) {
                    $avatar = $model->user->$userField;
                } else{
                    $avatar = Yii::$app->assetManager->getPublishedUrl("@vendor/soareseneves/yii2-chat-adminlte/assets/img/avatar.png");
                }
                    
                $output .= '<div class="direct-chat-msg left">
                    <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">' . $model->user->username . '</span>
                  <span class="direct-chat-timestamp pull-right">' . \kartik\helpers\Enum::timeElapsed($model->updateDate) . '</span>
                </div>
                <img class="direct-chat-img" src="' . $avatar . '" alt="message user image">
                <div class="direct-chat-text">
                ' . $model->message . '
                </div>
                </div>';
            }

        $result = ['data' => $output, 'pages' => $pages];

        return $result;
    }

}
