<?php

use yii\helpers\Url;

$forgotLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/forgot-password', 'token' => $link]);
?>
Привет, <?=$userEmail?>

Перейдите по ссылке ниже, чтобы сменить пароль:

<?=
 $forgotLink
 ?>
