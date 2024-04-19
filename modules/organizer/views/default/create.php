<?php

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Event $model */

$this->title = 'Создание мероприятия';

$this->registerCssFile('@web/css/main.css', ['depends' => BootstrapAsset::class]);
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
?>
<div class="event-create">
<section class="event-section">
<h1 class="event-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</section>
</div>
