<?php

/** @var yii\web\View $this */

use app\models\Event;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

// $this->registerCssFile('@web/css/main.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/card.css', ['depends' => BootstrapAsset::class]);

$this->title = 'Новые мероприятия';

?>
<div class="site-index">
<section>
<?php Pjax::begin(); ?>
<?php //echo $this->render('_search', ['model' => $searchModel]); ?>
<h1 class="event-title"><?= Html::encode($this->title) ?></h1>

<?= ListView::widget([
    'dataProvider' => $eventsNew,
    'itemView' => 'card',
    'layout' => '<div class="d-flex flex-wrap event-cards ">{items}</div>{pager}',
]); ?>

<?php Pjax::end(); ?> 
</section>
</div>

