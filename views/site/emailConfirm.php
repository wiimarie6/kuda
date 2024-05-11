<?php

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
$this->registerCssFile('@web/css/welcome.css', ['depends' => BootstrapAsset::class]);

?>


<section class="vh-100 gradient-custom">
  <div class="py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="container-center-block">
        <div class="card text-white welcome-container">
          <div class="card-body p-4 text-center">

            <div class="mb-md-3 mt-md-2">

              <h2 class="fw-bold mb-2 title-welcome">¿kuda?</h2>
              <p class="mb-5 title">На Вашу почту отправлено сообщение с подтверждением</p>

                <div>
                <?= Html::a('Отправить повторно', [''], ['class' => 'text-underline text-in', 'data' => [
                  'method' => 'post',
                ]]) ?>
                </div>

          </div>
        </div>
      </div>
    </div>
    </div>
</section>