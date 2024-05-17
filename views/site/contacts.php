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
                    <div class="card-body p-4">

                        <div class="mb-md-3 mt-md-2">

                            <h2 class="mb-3 title-account">Контакты</h2>
                            <div class="contacts-items text-center">

                                <div class="contact-item">
                                    <p class="text">Email: <span class="account-text">kuda@yandex.ru</span></p>
                                </div>
                                <div class="contact-item">
                                    <p class="text">Telegram: <a href="#tg" class="account-text" _target="blank">@kuda</a></p>
                                </div>


                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
</section>