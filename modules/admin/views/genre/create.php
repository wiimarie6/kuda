<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Genre $model */

$this->title = 'Создать жанр';
$this->params['breadcrumbs'][] = ['label' => 'Жанры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
