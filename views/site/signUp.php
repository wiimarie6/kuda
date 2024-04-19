<?php

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
$this->registerCssFile('@web/css/welcome.css', ['depends' => BootstrapAsset::class]);

?>

<section class="vh-100 gradient-custom">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-8">
        <div class="card text-white welcome-container">
          <div class="card-body p-4 text-center">

            <div class="mb-md-3 mt-md-3">
              <p class="mb-3 title">Регистрация</p>

                 <?php $form = ActiveForm::begin([
        'id' => 'registr-form',
        'fieldConfig' => [
            'options' => ['tag' => 'div'],
            'template' => "{label}{input}\n{hint}\n{error}",
            
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
        <?= $form->field($model, 'terms')->checkbox() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?= Html::a('Назад', ['welcome'], ['class' => 'text-underline text']) ?>

          </div>
        </div>
      </div>
    </div>
    </div>
</section>
