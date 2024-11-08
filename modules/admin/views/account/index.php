<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\widgets\Pjax;

$this->registerCssFile('@web/css/account.css', ['depends' => BootstrapAsset::class]);
?>
<section class="vh-100 gradient-custom">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="container-center-block">
        <div class="card text-white account-container">
          <div class="card-body p-4 text-center">

            <div class="mb-md-4 mt-md-4">
              <p class="mb-3 title-account">Личный кабинет администратора</p>
              <div class="info-account">
                <?php Pjax::begin(['id' => 'pjax-account']); ?>
                <p class="text">Имя: <span class="account-text"><?= Yii::$app->user->identity?->name ?></span></p>
                <p class="text">Email: <span class="account-text"><?= Yii::$app->user->identity?->email ?></span></p>
                <p class="text"><?= Html::a('Сменить пароль', ['new-password'], ['class' => 'text-underline text']) ?></p>
                <p class="text"><?= Html::a('Удалить аккаунт', ['delete'], ['class' => 'text-underline text btn-delete']) ?></p>
                <?php Pjax::end(); ?>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
Modal::begin([
  'title' => 'Для удаления аккаунта введите пароль',
  'id' => 'delete-modal'
]);
?>
<?php $form = ActiveForm::begin([
  'id' => 'account-delete-form',
  'action' => '/account/delete'
]); ?>
<div class="modal-button">

<?= $form->field($model, 'currentPassword', ['enableAjaxValidation' => true])->passwordInput() ?>

  <div class="form-group">
    <?= Html::a('Отмена', '', ['class' => ' text text-underline', 'id' => 'delete-btn-cancel']) ?>
    <?= Html::submitButton('Удалить', ['class' => 'btn btn-primary']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
<?
Modal::end();
?>
