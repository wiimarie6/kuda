<?php

/** @var yii\web\View $this */

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;

$this->registerCssFile('@web/css/main.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/card.css', ['depends' => BootstrapAsset::class]);


$this->title = 'Мероприятия, которые Вам понравились';
?>
<div class="site-index">
  <section>
    <h1 class="event-title"><?= Html::encode($this->title) ?></h1>
    <div class="row row-cols-1 row-cols-md-4 g-4">
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"><?= Html::a('Название мероприятия', [''], ['class' => 'text-underline text'])?></h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="../../web/css/images/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Название мероприятия</h5>
        <p class="card-text">29.10.2024</p>
      </div>
    </div>
  </div>
  
  
</div>
  </section>
</div>