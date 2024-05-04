<?php

use yii\helpers\Url;

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/email-verify', 'token' => $link]);
?>
Привет, <?=$userEmail?>

Перейдите по ссылке ниже, чтобы подвердить почту:

<?=
 $verifyLink
 ?>
