<?php

namespace app\controllers;

use app\models\CurrentPassword;
use app\models\EventLikes;
use app\models\EventUser;
use app\models\Genre;
use app\models\GenreUser;
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
        $model = new CurrentPassword();
        $eventsCount = EventUser::find()->where(['userId'=> Yii::$app->user->id])->count();
        $likesCount = EventLikes::find()->where(['userId'=> Yii::$app->user->id])->count();
        $genreModel = new GenreUser();
        $genres = Genre::getGenres();
        $userGenres = GenreUser::getGenresByUser();
        $genreSelectArray = GenreUser::find()->select('genreId')->where(['userId'=> Yii::$app->user->id])->asArray()->column();
        return $this->render('index', [
            'eventsCount' => $eventsCount,
            'likesCount' => $likesCount,
            'genreModel' => $genreModel,
            'genreSelectArray' => $genreSelectArray,
            'genres' => $genres,
            'userGenres' => $userGenres,
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
public function actionGenres(){
    $model = new GenreUser();


    if ($this->request->isPost && $model->load($this->request->post())){
        if ($model->validate()){
            GenreUser::deleteAll(['userId'=> Yii::$app->user->id]);
            foreach ($model->selectedGenres as $key => $value) {
                $genreUserModel = new GenreUser();
                $genreUserModel->userId = Yii::$app->user->id;
                $genreUserModel->genreId = $value;
                $genreUserModel->save(false);
            }
        }
    }
    return $this->redirect('/account');
}

public function actionDelete()
{
    $model = new \app\models\CurrentPassword();
    if ($this->request->isPost && $model->load($this->request->post())) {
        if ($model->deleteAccount()) {
            return $this->redirect("/site/welcome");
        }
    }
}
}