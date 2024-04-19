<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';

$this->registerCssFile('@web/css/welcome.css', ['depends' => BootstrapAsset::class]);

?>

<section class="vh-100 gradient-custom">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-8">
        <div class="card text-white welcome-container">
          <div class="card-body p-5 text-center">
            <div class="mb-md-5 mt-md-4">
            <div class="site-login">
                <h1 class="signIn-title"><?= Html::encode($this->title) ?></h1>

    <div class="row">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                // 'fieldConfig' => [
                //     'template' => "{label}\n{input}\n{error}",
                //     'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                //     'inputOptions' => ['class' => 'col-lg-3 form-control'],
                //     'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                // ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>


            <div class="form-group">
                <div>
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?= Html::a('Забыли пароль?', ['welcome'], ['class' => 'text-underline text']) ?>
        
    </div>
</div>
          </div>
        </div>
      </div>
    </div>
    </div>
</section>

