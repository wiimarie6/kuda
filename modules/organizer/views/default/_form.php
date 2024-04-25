<?php

use app\models\Genre;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Event $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);

?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'date')->textInput(['type' => 'datetime-local',
    'min' => date('Y-m-d H:i') , 'class' => 'form-control date-form']) ?>
    

    <?= $form->field($model, 'artists')->widget(MultipleInput::className(), [
        'min'               => 1, // should be at least 1 rows
        'allowEmptyList'    => false,
        'enableGuessTitle'  => true,
        'addButtonPosition' => MultipleInput::POS_HEADER,
        'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME // show add button in the header
    ])
    ->label(false);?>

    <?= $form->field($model, 'genreId')->dropDownList(Genre::getGenres(), ['prompt' => 'Выберите жанр...']) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group", style="display: flex; justify-content: center;">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
