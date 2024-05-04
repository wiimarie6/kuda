
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;

$this->title = 'Выберете интересующие жанры';

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

    <div class="form-genre">

<?php $form = ActiveForm::begin(
); ?>
  <div class="genre-checkbox" id="genre-select-all">
      Выбрать все
  </div>
        <?= $form->field($model, 'selectedGenres', ['template' => '{input}'])->checkboxList($genres, [
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
    </div>
</div>
          </div>
        </div>
      </div>
    </div>
    </div>
</section>

