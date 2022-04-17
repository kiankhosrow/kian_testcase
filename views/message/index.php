<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;
use app\models\Message;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title.' Message Board';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
.item:hover{
    background-color: #eee;
}
.item{
    text-align: center;
    border-top: 1px solid #cdcdcd;
    margin-top: 30px;
    padding: 10px;
    box-shadow: 7px 5px 5px #cdcdcd;
}
.row div img{
    margin: 10px;
}
.row div p{
    padding-top: 10px;
    text-align: left;
}
.help-block{
    color: red;
}
.linediv{
    border-left-width: thin;
    border-radius: 5px;
    background-color: whitesmoke;

}
.message_box{
    border: 1px solid lightgray;
    margin: auto;

}
</style>
<div class="message-index">
<div class="row">
    <div class="col-md-8 message_box">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($is_me): ?>
        <!-- <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Post Message</a> -->

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'message')->textArea(['maxlength' => 250,'rows'=>5,'placeHolder'=>'What`s happening?','label'=>false])->label(false) ?>
        <?= Html::submitButton('Tweet', ['class' => 'btn btn-primary s-btn','style'=>'margin-bottom:20px;']) ?>
        <?php ActiveForm::end(); ?>


    <?php endif; ?>


    <?php Pjax::begin(); ?>

    <?php 
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        // 'itemView' => '_post',
        'itemOptions' => [
            'tag' => false
        ],
        'options' => [
            'tag' => 'div',
            'class' => 'row',
        ],
        'layout' => "{pager}\n{items}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_post',['model' => $model]);
        }
    ]);
    ?>
    <?php Pjax::end(); ?>
    </div>
    <div class="col-md-3 linediv">
        <h4>Your followers</h4>
        <?php

        foreach ($players as $p){
            echo "<div class='col-md-12'>
        ";
           echo "<h6 style='text-align: left;'>";
            echo Html::img('@web/img/user.png',['height'=>'20px']);

            echo Html::a(Html::encode($p->first_name)." ". Html::encode($p->last_name), ['message/index','user_id'=>$p->id]);
           echo" </h6>
                </div>";

        }

        ?>
    </div>

</div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script type="text/javascript">addUrl = "<?=Url::toRoute(['message/create']);?>"</script>
<script type="text/javascript">
    jQuery(function ($) {
    $('.s-btn').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: addUrl,
                type: 'POST',
                data: $('#w0').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $($this).find('button[type="submit"]').prop('disabled', true);
                },
                success: function(result) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    if(typeof result['message-message'] === 'undefined')
                    {
                        $('.field-message-message').find('.help-block').html("");
                        location.reload();
                    }
                    else
                        $('.field-message-message').find('.help-block').html(result['message-message'][0]);
                },
                error: function(error) {
                    $($this).find('button[type="submit"]').prop('disabled', false);
                    // alert('Something went wrong!', addUrl);
                    location.reload();
                }
            });
        });
    })
</script>
