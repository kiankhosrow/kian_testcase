<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Player;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PlayerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Player List';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
.row .col-md-3 div{
    text-align: center;
    border: 1px solid #cdcdcd;
    margin-top: 30px;
}
.row div img{
    margin: 10px;
}
.follow-user{
    margin-bottom: 5px;
}
</style>
<div class="player-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?php if(Yii::$app->user->identity->user_type==1):?>
        <p>
            <?= Html::a('Create Player', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'first_name',
            'last_name',
            'email:email',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            // 'status',
            //'user_type',
            // 'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Player $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    <?php else:?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            return $this->render('_player',['model' => $model]);
        }
    ]);
    ?>

    <?php endif;?>

</div>

<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script type="text/javascript">follw = "<?=Url::toRoute(['site/follow']);?>"</script>
<script type="text/javascript">
    jQuery(function ($) {
    $('.follow-user').click(function(event) {
        event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: follw,
                type: 'GET',
                data: {user_id:$this.attr('data-id')},
                beforeSend: function() {
                    
                },
                success: function(result) {
                    $this.html(result); 
                },
                error: function(error) {
                    alert('Something went wrong!', 'error');
                    // location.reload();
                }
            });
        });
    })
</script>
