<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;

$this->registerCssFile('@web/css/account.css', ['depends' => BootstrapAsset::class]);
?>
<section class="vh-100 gradient-custom">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="container-center-block">
        <div class="card text-white account-container">
          <div class="card-body p-4 text-center">

            <div class="mb-md-4 mt-md-4">
              <p class="mb-3 title-account">Смена пароля</p>
<div class="account-newPassword">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>


          </div>
        </div>
      </div>
    </div>
    </div>
</section>