<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Player */

$this->title = 'Update Player: ' . $model->first_name.' '.$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Players', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="player-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
