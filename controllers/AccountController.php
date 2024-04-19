<?php

namespace app\controllers;

use app\models\EventLikes;
use app\models\EventUser;
use app\models\NewPassword;
use app\models\User;
use mysqli;
use Symfony\Component\VarDumper\VarDumper;
use Yii;
use yii\db\Query;
use yii\web\Controller;

class AccountController extends Controller {

    public function actions() {
        //TODO: Организатор
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
    }

    public function actionIndex() {
        $eventsCount = EventUser::find()->where(['userId'=> Yii::$app->user->id])->count();
        $likesCount = EventLikes::find()->where(['userId'=> Yii::$app->user->id])->count();
        return $this->render('index', [
            'eventsCount' => $eventsCount,
            'likesCount' => $likesCount,
        ]);
    }

    public function actionNewPassword()
{
    $model = new \app\models\NewPassword();
    if ($model->load(Yii::$app->request->post())) {
        if ($model->changePassword()) {
         $this->redirect("/account/");
            
        }
    }

    return $this->render('newPassword', [
        'model' => $model,
    ]);
}

public function actionDelete()
{
    $user = User::findOne(Yii::$app->user->id);
    Yii::$app->user->logout();
    $user->delete();
    $this->redirect(['/site/welcome']);
}


}