<?php

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
$this->registerCssFile('@web/css/welcome.css', ['depends' => BootstrapAsset::class]);

?>


<section class="vh-100 gradient-custom">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-8">
        <div class="card text-white welcome-container">
          <div class="card-body p-5 text-center">

            <div class="mb-md-3 mt-md-2">

              <h2 class="fw-bold mb-2 title-welcome">¿kuda?</h2>
              <p class="mb-5 title">Здесь вы сможете найти то мероприятие, которое Вам точно понравится </br> Давайте начнём?</p>

             
            <?= Html::a('Регистрация', ['sign-up'], ['class' => 'btn btn-welcome']) ?>

            <div>
                <p class="mb-0 text-in">У Вас уже есть аккаунт?
                    </p>
                <?= Html::a('Войти', ['sign-in'], ['class' => 'text-underline text-in']) ?>
                </div>

          </div>
        </div>
      </div>
    </div>
    </div>
</section>