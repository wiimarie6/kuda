<?php

use app\models\EventLikes;
use app\models\EventUser;
use app\models\Genre;
use app\models\Role;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Event $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/event.css', ['depends' => BootstrapAsset::class]);
?>
<section>
<div class="event-view">

    <?php Pjax::begin(['id' => 'pjax-event']); ?>
    
    <div class="event-container d-flex flex-column">
        <div class="event-container-main d-flex flex-wrap justify-content-center justify-content-lg-start">
            <div class="event-container-image d-flex flex-column">
                <?= Html::img('@web/uploads/' . $model->image, ['class' => 'event-image']) ?>

                <div class="event-container-like d-flex align-items-center">
                    <a href="/site/like?id=<?=$model->id?>" class="text-decoration-none d-flex align-items-center">

                        <?=
                        (EventLikes::getIsLiked($model->id)) ?
                        Html::img('@web/css/images/liked.png', ['class' => 'event-like-image'])
                        :
                        Html::img('@web/css/images/unliked.png', ['class' => 'event-like-image'])

                        ?>
                        
                        <span class="event-like-text"> Хочу сходить</span>
                    </a>
                </div>
            </div>

            <div class="event-container-info d-flex flex-column">

                <h2 class="event-title-view"><?= Html::encode($model->title) ?></h2>
                <div class="event-container-date-buy d-flex justify-content-between align-items-center flex-wrap">
                    <div class="event-container-date">
                        <h5 class="event-subtitle">Дата проведения:</h5>
                        <span class="event-date-text"><?=Yii::$app->formatter->asDate($model->date, 'php:d.m.Y H:i')?></span>
                    </div>


                    <?= Role::getRoleId('Admin') ? '' : ((!EventUser::getIsSignedUp($model->id)) ? Html::a('Купить билеты',['', 'id' => $model->id], ['class' => 'btn', 'data' => ['method' => 'post']]) : Html::a('Отписаться', ['', 'id' => $model->id], ['class' => 'btn', 'data' => ['method' => 'post']]))?>
                    <?= (Role::getRoleId('Admin') ? Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn-delete-event']) : '')  ?>
                </div>
                <div class="event-container-about">
                    <h5 class="event-subtitle">
                        О событии:
                    </h5>
                    <p class="event-about "><?= Html::encode($model->description) ?></p>
                </div>
            </div>
        </div>
        <div class="event-container-about">
                    <h5 class="event-subtitle">
                        Жанр:
                    </h5>
                    <p class="event-about "><?= Html::encode(Genre::getGenreById($model->genreId)) ?></p>
                </div>
        <div class="event-container-artists">
            <h5 class="event-subtitle">Исполнители:</h5>
            <div class="event-artists-items d-flex flex-wrap align-items-center">
            <?php foreach ($artistsModel as $value): ?>
                        
                <div class="event-artists-item">
                    <h3 class="event-artists-title"><?= Html::encode($value['name'])?></h3>
                </div>
                        <?php endforeach;?>
            </div>
        </div>

        <div class="event-container-place d-flex flex-column">
            <h5 class="event-subtitle">
                Место проведения:
            </h5>
            <div class="event-place-text"> <?=Html::encode( $model->location) ?></div>
            <div class="event-container-map">

            </div>
        </div>

        <div class="event-container-price d-flex flex-column">
            <h5 class="event-subtitle">
                Стоимость:
            </h5>
            <div class="event-price">
                Цена билетов от <?= Html::encode($model->price)?> рублей
            </div>
            <div class="event-price-btn">
            <?= Role::getRoleId('Admin') ? '' : ((!EventUser::getIsSignedUp($model->id)) ?Html::a('Купить билеты',['', 'id' => $model->id], ['class' => 'btn', 'data' => ['method' => 'post']]) : Html::a('Отписаться', ['', 'id' => $model->id], ['class' => 'btn', 'data' => ['method' => 'post']]))?>
            <?= (Role::getRoleId('Admin') ? Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn-delete-event']) : '')  ?>
            </div>
        </div>
    </div>
                <?php Pjax::end(); ?>

</div>
</section>

<?php
Modal::begin([
  'title' => 'Вы уверены, что хотите удалить мероприятие?',
  'id' => 'delete-modal',
]);
?>
<div class="modal-button">
  <?= Html::a('Отмена', '', ['class' => 'btn text text-underline', 'id' => 'delete-btn-cancel']) ?>
  <?= Html::a('Удалить', [''], ['class' => 'btn delete-btn', 'id' => 'delete-btn-confirm', 'data' => [
    'method' => 'post',
  ]]) ?>
</div>

<?
Modal::end();
?>