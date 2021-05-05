<?php
use yii\helpers\Html;
use Yii;
use \yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>     
    </nav>

    <?php

    if(Yii::$app->user->isGuest) {
        
    } else {
        echo 
            
            Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout' ,
                ['class' => 'btn btn-link logout pull-right']
            )
            . Html::endForm();
    }

    ?>
</header>
