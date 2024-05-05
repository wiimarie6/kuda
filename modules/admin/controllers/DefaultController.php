<?php

namespace app\modules\admin\controllers;

use app\models\Role;
use app\models\User;
use app\models\UserSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    public function actions()
    {
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin) {
            $this->goBack();
        }
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $query = User::find()->where(['roleId'=> 3]);
        $dataProvider = $searchModel->search($this->request->queryParams, $query);

        return $this->render('index', [
            'title' => 'Организаторы',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUsers()
    {
        $searchModel = new UserSearch();
        $query = User::find()->where(['roleId'=> 1]);
        $dataProvider = $searchModel->search($this->request->queryParams, $query);

        return $this->render('index', [
            'title' => 'Пользователи',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangeRole($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost) {

            $model->roleId = Role::getRoleId('Organizer');
            if ($model->save(false)){
                return $this->redirect(['/admin/']);
            }
        }

        return $this->redirect(['/admin/']);
    }
}
