<?php

/** @var yii\web\View $this */

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->registerCssFile('@web/css/main.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/card.css', ['depends' => BootstrapAsset::class]);


$this->title = 'Мероприятия, которые Вам понравились';
?>
<div class="site-index">
  <section>
    <h1 class="event-title"><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'card',
    'layout' => '<div class="d-flex flex-wrap event-cards ">{items}</div>{pager}'
]); ?>

<?php Pjax::end(); ?> 
  </section>
</div>