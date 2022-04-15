<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\Follow;

$user_id = Yii::$app->user->identity->id;

$check = Follow::find()->where(['user_id'=>$user_id,'touser_id'=>$model->id])->one();
if($check)
{
    $status = "Following";
}
else{
    $status = "Follow";
}

?>
<div class="col-md-3">
    <?php ob_start(); ?>
    <div class="item">
    <?php echo Html::img('@web/img/user.png',['height'=>'100px']) ?>
    <h4 style="text-align: center;">
        <?= Html::encode($model->first_name) ?> <?= Html::encode($model->last_name) ?>
    </h4>
    <button type="button" class="btn btn-primary follow-user" data-id="<?=$model->id?>"><?=$status?></button>
    
    </div>
    <?php $lable =  ob_get_clean(); ?>


     <?= Html::a($lable, ['message/index','user_id'=>$model->id]) ?>
    
</div>
