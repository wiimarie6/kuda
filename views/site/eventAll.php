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

$this->title = 'Все мероприятия';

$query = Event::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_ASC
                ]
            ]
        ]);
?>
<div class="site-index">
<section>
<?php Pjax::begin(); ?>
<?php //echo $this->render('_search', ['model' => $searchModel]); ?>
<h1 class="event-title"><?= Html::encode($this->title) ?></h1>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'card',
    'layout' => '<div class="d-flex flex-wrap event-cards ">{items}</div>{pager}'
]); ?>

<?php Pjax::end(); ?> 
</section>
</div>

