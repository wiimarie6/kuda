<?php

namespace app\modules\organizer\controllers;

use app\models\CurrentPassword;
use app\models\Event;
use app\models\EventLikes;
use app\models\EventUser;
use app\models\NewPassword;
use app\models\User;
use mysqli;
use Symfony\Component\VarDumper\VarDumper;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response;

class AccountController extends Controller {

    public function actions()
    {
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isOrganizer) {
            $this->goHome();
        }
    }
    // public function actions() {
    //     //TODO: Организатор
    //     if (Yii::$app->user->isGuest) {
    //         $this->goHome();
    //     }
    // }

    public function actionIndex() {
        $model = new CurrentPassword();

        $eventsOrg = Event::find()->where(['userId'=> Yii::$app->user->id])->count();
        return $this->render('index', [
            'eventsOrg' => $eventsOrg,
            'model' => $model,
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
    $model = new \app\models\CurrentPassword();
    if ($this->request->isPost && $model->load($this->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        if ($model->deleteAccount()) {
            return $this->redirect("/site/welcome");
        } else {

            return $this->redirect("/account");
        }
    }
}
}