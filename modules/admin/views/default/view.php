<?php

use app\models\Role;
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
      <div class="col-8">
        <div class="card text-white account-container">
          <div class="card-body p-5 text-center">

            <div class="mb-md-4 mt-md-4">
              <p class="mb-3 title-account"><?= ($model->roleId ==1)? 'Пользователь' : 'Организатор'?></p>
              <div class="info-account">
                <?php Pjax::begin(['id' => 'pjax-account']); ?>
                <p class="text">Имя: <span class="account-text"><?= Html::encode($model->name)?></span></p>
                <p class="text">Email: <span class="account-text"><?= Html::encode($model->email) ?></span></p>
                <p class="text"><?=((Role::getRoleById($model->roleId) == 'Organizer') ? '' : 
                Html::a('Сделать организатором', ['change-role', 'id' => $model->id], ['class' => 'text-underline text btn-change-role', 'data' => ['method' => 'post']]));?></p>
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
  'title' => 'Вы уверены, что хотите удалить аккаунт?',
  'id' => 'delete-modal'
]);
?>
<div class="modal-button">
  <?= Html::a('Отмена', '', ['class' => 'btn text text-underline', 'id' => 'delete-btn-cancel']) ?>
  <?= Html::a('Удалить', ['delete'], ['class' => 'btn delete-btn', 'id' => 'delete-btn-confirm', 'data' => [
    'method' => 'post',
  ]]) ?>
</div>

<?
Modal::end();
?>


<?php
Modal::begin([
  'title' => 'Вы уверены, что хотите сделать пользователя организатором?',
  'id' => 'change-modal'
]);
?>
<?php $form = ActiveForm::begin([
  'id' => 'change-form',
  'action' => '/default/change-role'
]); ?>
<div class="modal-button">
  <div class="form-group">
    <?= Html::a('Отмена', '', ['class' => 'text text-underline', 'id' => 'change-btn-cancel']) ?>
    <?= Html::submitButton('Сделать организатором', ['class' => 'btn btn-primary']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
  
<?
Modal::end();
?>