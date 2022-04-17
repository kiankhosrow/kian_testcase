<?php

/** @var yii\web\View $this */

$this->title = 'Kian Testcase';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h6 class="display-6">Welcome to Communication Platform for Players of the Game “Grand Theft Auto Online”</h6>
        <div class="row align-items-center justify-content-center">
            <img src="<?php echo  Yii::getAlias('@web').'/img/game.jpg';?>" alt="Grand Theft Auto Online" />
        </div>
        <br/>
        <?php
        if(!isset(Yii::$app->user->identity->first_name)){
        ?>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7">
                <a href='kian_testcase/site/login' class="btn btn-info btn-block">Login</a>
            </div>
        </div>
        <?php
        }else{
        ?>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <a href='kian_testcase/message/' class="btn btn-info btn-block">Message Board</a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

</div>
