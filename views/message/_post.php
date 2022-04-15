<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="col-md-12">
    <div class="row item">
        <div class="col-md-2 text-center">
        <?php echo Html::img('@web/img/user.png',['height'=>'80px']) ?>
        <h5 style="text-align: center;">
            <?php if(isset($model->user->first_name)):?>
            <?= Html::encode($model->user->first_name) ?> <?= Html::encode($model->user->last_name) ?>
            <?php endif; ?>
        </h5>
        </div>
        <div class="col-md-10">
        <p><?= HtmlPurifier::process($model->message) ?></p>
        <p><b>date : </b><?= HtmlPurifier::process($model->created_date) ?></p>
        </div>
    </div>
</div>
