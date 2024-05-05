<?php

use app\models\Role;
use app\models\User;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
$this->title = 'Панель администратора';
$this->registerCssFile('@web/css/panel.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/genre.css', ['depends' => BootstrapAsset::class]);

?>
<div class="admin-default-index">
<h1 class="genre-title"><?= Html::encode($this->title) ?></h1>

    <div class="panel-links">
        <?= Html::a('Организаторы', ['/admin/'], ['class' => 'btn btn-panel-link']) ?>
        <?= Html::a('Пользователи', ['/admin/default/users'], ['class' => 'btn btn-panel-link']) ?>
        <?= Html::a('Жанры', ['/admin/genre'], ['class' => 'btn btn-panel-link']) ?>
</div>

    <h1 class="genre-title"><?=$title?></h1>

    <?php Pjax::begin([
        'id' => 'pjax-change',
    ]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'name',
                'label' => 'Имя'
            ],
            [
                'attribute' => 'email',
                'label' => 'Почта',
            ],
            [
                'attribute' => 'createAt',
                'label' => 'Создан'
            ],
            //'updateAt',
            //'authKey',
            [
                'content' => function (User $model) {
                    return Html::a('Посмотреть', ['view', 'id' => $model->id], ['class' => 'btn btn-view']);
                }
            ],
        ],
    ]); ?>

<?php Pjax::end(); ?>
</div>


