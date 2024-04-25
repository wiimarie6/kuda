<?php

namespace app\controllers;

use app\models\Artist;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Event;
use app\models\EventLikes;
use app\models\GenreUser;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Event::find();

        $eventsSoon = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_ASC
                ]
                ],
            'pagination' => [
                'pageSize' => 4,
                'pageSizeLimit' => 4
            ],
        ]);

        $eventsNew = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'createdAt' => SORT_DESC,
                    ]
                ],
                'pagination' => [
                    'pageSize' => 4,
                    'pageSizeLimit' => 4
                ],
        ]);


        $eventsAll =  new ActiveDataProvider([
            'query' => Event::find()->orderBy('RAND()'),
            'pagination' => [
                'pageSize' => 4,
                'pageSizeLimit' => 4
            ],
        ]);


        if(Yii::$app->user->isGuest) {
            $this->redirect('/site/welcome');
        }
        return $this->render('index', [
            'eventsSoon' => $eventsSoon,
            'eventsNew' => $eventsNew,
            'eventsAll' => $eventsAll,
        ]);
    }

    public function actionWelcome()
    {
        $this->layout = 'withoutHeader';
        return $this->render("welcome");
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionSignIn()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'withoutHeader';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('signIn', [
            'model' => $model,
        ]);
    }

    public function actionSignUp()
{
    $this->layout = 'withoutHeader';

    $model = new \app\models\User();

    if ($model->load(Yii::$app->request->post())) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->save()){
            if (Yii::$app->user->login($model)){
                return $this->goHome();
            }
        }
    }
    return $this->render('signUp', [
        'model' => $model,
    ]);
}
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/site/welcome');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEventLikes()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Event::find()->rightJoin('event_likes', 'event_likes.eventId = event.id')->where(['event_likes.userId' => Yii::$app->user->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
                ]);
        return $this->render('eventLikes', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEventAll()
    {
        return $this->render('eventAll', []);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $artistsModel = Artist::getArtistsByEventId($model->id);
        return $this->render('view', [
            'model' => $model,
            'artistsModel' => $artistsModel

        ]);
    }

    public function actionLike($id)
    {
        $model = $this->findModel($id);

        if (!$eventLike=EventLikes::getIsLiked($id)){
            $eventLike= new EventLikes();
            $eventLike->userId = Yii::$app->user->id;
            $eventLike->eventId= $id;
            $eventLike->save();
        } else {
            $eventLike->delete();
        }
        return $this->redirect(['view', 'id' => $id]);
    }

   

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne(['id' => $id])) !== null) {
            return $model;
        }
    }
}
