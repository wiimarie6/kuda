<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerCssFile('@web/css/style.css', ['depends' => BootstrapAsset::class]);
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-lg  d-md navbar-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'Контакты', 'url' => ['/site/contacts']],
            !Yii::$app->user->isGuest && !Yii::$app->user->identity->isOrganizer && !Yii::$app->user->identity->isAdmin ? ['label' => 'Профиль', 'url' => ['/account/']] : '',
            !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin ? ['label' => 'Профиль', 'url' => ['/admin/account/']] : '',
            !Yii::$app->user->isGuest && Yii::$app->user->identity->isOrganizer ? ['label' => 'Профиль', 'url' => ['/organizer/account/']] : '',
            !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin && !Yii::$app->user->identity->isOrganizer ? ['label' => 'Избранное', 'url' => ['/site/event-likes']] : '',
            Yii::$app->user->identity->isOrganizer ? ['label' => 'Ваши мероприятия', 'url' => ['/organizer/']] : '',
            Yii::$app->user->identity->isAdmin ? ['label' => 'Панель администратора', 'url' => ['/admin/']] : '',

            '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Выход ('  . Yii::$app->user->identity?->email . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container-block">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<!--
<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; ¿kuda? <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>
-->      
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
