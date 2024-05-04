<?php

use app\models\Genre;
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
          <div class="card-body p-4 text-center">

            <div class="mb-md-4 mt-md-4">
              <p class="mb-3 title-account">Личный кабинет</p>
              <div class="info-account">
                <?php Pjax::begin(['id' => 'pjax-account']); ?>
                <p class="text">Имя: <span class="account-text"><?= Yii::$app->user->identity?->name ?></span></p>
                <p class="text">Email: <span class="account-text"><?= Yii::$app->user->identity?->email ?></span></p>
                <p class="text"><?= Html::a('Понравившиеся:', ['site/event-likes'], ['class' => 'text-underline text']) ?> <span class="account-text"><?= $likesCount ?></span></p>
                <p class="text"><?= Html::a('Мероприятия, на которые Вы записаны: ', ['site/event-user'], ['class' => 'text-underline text']) ?><span class="account-text"><?= $eventsCount ?></span></p>
                <p class="text"><a href="" class="account-link" data-bs-toggle="modal" data-bs-target="#genre-modal">Интересующие жанры</a></p>
                <div class="container-genres" >
                  <?php foreach($userGenres as $key => $value):?>
                  <div class="genre-checkbox genre-checkbox-index <?=((strlen($value)>20) ? 'large large-index' : '' )?>"><?=Html::encode($value)?></div>
                  <?php endforeach;?>
                </div>
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

<?= $form->field($model, 'currentPassword')->passwordInput() ?>

  <div class="form-group">
    <?= Html::a('Отмена', '', ['class' => 'btn text text-underline', 'id' => 'delete-btn-cancel']) ?>
    <?= Html::submitButton('Удалить', ['class' => 'btn btn-primary']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
<?
Modal::end();
?>


<?php
Modal::begin([
  'id' => 'genre-modal',
  // 'data' => [
  //   'bs-backdrop' => 'stati'
  // ]
]);
?>

<div class="form-genre">

  <?php $form = ActiveForm::begin([
    'action' => '/account/genres'
  ]
); ?>
    <div class="genre-checkbox" id="genre-select-all">
        Выбрать все
    </div>
          <?= $form->field($genreModel, 'selectedGenres', ['template' => '{input}'])->checkboxList($genres, [
            'item' => function($index, $label, $name, $checked, $value) use ($genreSelectArray){
              if (in_array($value, $genreSelectArray)){

                $checked = 'checked';
              }

        return "<label class='col-md-4 genre-checkbox ".(($checked) ? 'genre-checked' :'')." ".((strlen($label)>20) ? 'large' : '' )."' style='font-weight: normal;'><input class='d-none' type='checkbox' {$checked} name='{$name}' value='{$value}'>{$label}</label>";

            }
          ]) ?>
      
          <div class="form-group">
              <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
          </div>
      <?php ActiveForm::end(); ?>
</div>


<?
Modal::end();
?>