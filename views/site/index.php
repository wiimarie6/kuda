<?php

/** @var yii\web\View $this */

use app\models\Event;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->registerCssFile('@web/css/main.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/card.css', ['depends' => BootstrapAsset::class]);

$this->title = '¿kuda?';

$query = Event::find();

$dataProvider = new ActiveDataProvider([
  'query' => $query,
  'sort' => [
      'defaultOrder' => [
          'date' => SORT_ASC
      ]
  ],
  'pagination' => [
    'pageSize' => 4,
  ]
      
]);
?>
<div class="site-index">
  <div class="site-index">
    <section>
      <div class="block-title">
        <h1 class="main-title">Предстоящие</h1>
        <?= Html::a('Посмотреть все...', ['site/event-upcoming'], ['class' => 'text-underline text']) ?>
      </div>
      <div class="">

<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= ListView::widget([
    'dataProvider' => $eventsSoon,
    'itemView' => 'card',
    'layout' => '<div class="d-flex event-cards ">{items}</div>{pager}',
]); ?>

<?php Pjax::end(); ?>
      </div>

      <div class="block-title">
        <h1 class="main-title">Новые</h1>
        <?= Html::a('Посмотреть все...', ['site/event-new'], ['class' => 'text-underline text']) ?>
      </div>
      <div class="">
      <?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= ListView::widget([
    'dataProvider' => $eventsNew,
    'itemView' => 'card',
    'layout' => '<div class="d-flex event-cards ">{items}</div>{pager}'
]); ?>

<?php Pjax::end(); ?>
        </div>

      <div class="block-title">
        <h1 class="main-title">Все мероприятия</h1>
        <?= Html::a('Посмотреть все...', ['site/event-all'], ['class' => 'text-underline text']) ?>
      </div>
      <div class="">
      <?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= ListView::widget([
    'dataProvider' => $eventsAll,
    'itemView' => 'card',
    'layout' => '<div class="d-flex event-cards ">{items}</div>{pager}'
]); ?>

<?php Pjax::end(); ?>
        </div>
      </div>