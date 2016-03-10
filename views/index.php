<?php
use yii\widgets\LinkPager;
use kop\y2sp\ScrollPager;
use app\components\UserOptions;
?>

<?php

$css = UserOptions::get('chat_collapse') ? 'collapsed-box' : '';

?>

<div class="box box-success direct-chat <?= $css ?>">
    <div class="box-header ui-sortable-handle" style="cursor: move;">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Chat</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool c-minimize" data-widget="collapse"><i class="fa fa-<?= empty($css) ? 'minus' : 'plus' ?>"></i></button>
            <button class="btn btn-box-tool c-close" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="direct-chat-messages">            
            <?=$data?>
        </div>
    </div>
    <div class="box-footer">
        <div class="input-group">
            <input name="Chat[message]" id="chat_message" placeholder="Mensagem..." class="form-control">
            <div class="input-group-btn">
                <button class="btn btn-success btn-send-comment" data-url="<?=$url;?>" data-model="<?=$userModel;?>" data-userfield="<?=$userField;?>" data-loading="<?=$loading;?>"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
        <?php 

        echo ScrollPager::widget([
            'pagination' => $pages,
            'container' => '.direct-chat-messages',
            'item' => '.direct-chat-msg',
            'triggerText' => 'Mais Mensagens',
            'triggerOffset' => 3,
            'noneLeftText' => 'Fim das Mensagens',
        ]);

        ?>
</div><!-- /.box (chat box) -->  