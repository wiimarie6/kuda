<?php

/** @var yii\web\View $this */

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
$this->registerCssFile('@web/css/card.css', ['depends' => BootstrapAsset::class]);
?>
<div class="col">
  <a href="/site/view?id=<?=$model->id?>" class="text-decoration-none">
    <div class="card">
      <?= Html::img('@web/uploads/' . $model->image, ['class' => 'card-img-top event-card-image'])?>
      <div class="card-body">
        <h5 class="card-title"><?= Html::encode($model->title)?></h5>
        <p class="card-text"><?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y H:i')?></p>
      </div>
    </div>
  </a>
  </div>