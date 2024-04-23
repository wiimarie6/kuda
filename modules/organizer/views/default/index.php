<?php

use app\models\Event;
use app\models\Genre;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ваши мероприятия';
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
?>
<div class="event-index">

    <h1 class="event-title text-center"><?= Html::encode($this->title) ?></h1>

    <p class="create-event-p">
        <?= Html::a('Создать мероприятие', ['create'], ['class' => 'btn btn-create']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'card',
        'layout' => '<div class="d-flex flex-wrap event-cards ">{items}</div>{pager}'
    ]); ?>

    <?php Pjax::end(); ?>

</div>
