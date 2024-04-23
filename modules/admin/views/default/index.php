<?php

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
$this->title = 'Панель администратора';
$this->registerCssFile('@web/css/genre.css', ['depends' => BootstrapAsset::class]);

?>
<div class="admin-default-index">
<h1 class="genre-title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Жанры', ['/admin/genre'], ['class' => 'btn btn-create-genre']) ?>
    </p>
</div>
