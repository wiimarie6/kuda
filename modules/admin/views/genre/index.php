<?php

use app\models\Genre;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile('@web/css/genre.css', ['depends' => BootstrapAsset::class]);
$this->title = 'Жанры';
?>
<div class="genre-index">
    <?php Pjax::begin([
        'id' => 'pjax-genre'
        ]); ?>
    <p>
        <?= Html::a('Назад', ['/admin/'], ['class' => 'btn btn-back-genre']) ?>
    </p>
    <h1 class="genre-title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать жанр', ['create'], ['class' => 'btn btn-create-genre']) ?>
    </p>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            [
                'content' => function (Genre $model) {
                    return Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-update-genre']) .
                        Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-delete-genre',]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
Modal::begin([
    'title' => 'Вы уверены, что хотите </br> удалить жанр?',
    'id' => 'delete-modal'
]);
?>
<div class="modal-button">
    <?= Html::a('Отмена', '', ['class' => 'text text-underline', 'id' => 'btn-cancel']) ?>
    <?= Html::a('Удалить', ['delete'], ['class' => 'btn delete-btn', 'id' => 'delete-btn-confirm', 'data' => [
        'method' => 'post',
    ]]) ?>
</div>

<?
Modal::end();
?>

<?php
Modal::begin([
    'title' => 'Редактировать жанр',
    'id' => 'update-modal'
]);
?>
<div class="modal-button">
    <?php $form = ActiveForm::begin([
        'id' => 'form-upload',
    ]); ?>

    <?= $form->field($modelUpdate, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::a('Отмена', '', ['class' => 'text text-underline', 'id' => 'btn-cancel-title']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn genre-modal-btn', 'id' => 'update-btn-confirm']) ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>

<?
Modal::end();
?>

<?php
Modal::begin([
    'title' => 'Создать жанр',
    'id' => 'create-modal'
]);
?>
<div class="modal-button">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
    ]); ?>

    <?= $form->field($modelCreate, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::a('Отмена', '', ['class' => 'text text-underline', 'id' => 'btn-cancel']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn genre-modal-btn', 'id' => 'create-btn-confirm']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?
Modal::end();
?>