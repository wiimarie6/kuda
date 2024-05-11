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
use app\models\EventUser;
use app\models\ForgotPassword;
use app\models\Genre;
use app\models\GenreUser;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

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
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif ( Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
        $userGenres = GenreUser::find()->select('genreId')->where(['userId'=> Yii::$app->user->id])->asArray()->column();
        if (Yii::$app->user->identity->isUser) {
            
            $query = Event::find()->where(['genreId' => $userGenres]);
        } else {
            $query = Event::find();
        }

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
                Yii::$app->mailer->compose('verification', ['userEmail' => $model->email, 'link' => $model->emailLink])->setFrom(env('YANDEX_LOGIN'))->setTo($model->email)->setSubject('kuda Подтверждение почты')->send();

                return $this->redirect('/site/email-confirm/');
            }
        }
    }

    return $this->render('signUp', [
        'model' => $model,
        
    ]);
}
    public function actionEmailVerify($token)
    {

    $user = User::findOne(['emailLink'=>$token]);
    if ($user){
        if (!$user->getIsVerified()){

            $user->emailVerifiedAt = date('Y-m-d H:i:s');
            $user->emailLink = null;
            $user->save(false);
            return $this->redirect('/site/genres');
        } else {
            return $this->redirect('/site/genres');
        }
    }
    return $this->redirect('/site/welcome');
    }

    public function actionEmailConfirm() 
    {
        $this->layout = 'withoutHeader';

        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isVerified){
            return $this->redirect('/site/');
        }
        if ($this->request->isPost){

                Yii::$app->mailer->compose('verification', ['userEmail' => Yii::$app->user->identity->email, 'link' => Yii::$app->user->identity->emailLink])->setFrom(env('YANDEX_LOGIN'))->setTo(Yii::$app->user->identity->email)->setSubject('kuda Подтверждение почты')->send();
                Yii::$app->session->setFlash('info', 'Сообщение отправлено');
                return $this->refresh();
        }
        return $this->render('emailConfirm');
    }
    public function actionForgotConfirm()
    {
        $this->layout = 'withoutHeader';
        $model = new LoginForm();

        if ($this->request->isPost && $model->load($this->request->post())){
            
            if ($model->validate('email')){
                $user = User::findByEmail($model->email);
                if ($user) {

                    $user->emailLink = Yii::$app->security->generateRandomString();
                    $user->save(false);
                    Yii::$app->mailer->compose('changePassword', ['userEmail' => $model->email, 'link' => $user->emailLink ?? Yii::$app->security->generateRandomString()])->setFrom(env('YANDEX_LOGIN'))->setTo($model->email)->setSubject('kuda Смена пароля')->send();
                }
                Yii::$app->session->setFlash('info', 'Сообщение отправлено на указанную почту');
                return $this->refresh();
            }
        }
        return $this->render('forgotConfirm',[
            'model' => $model
        ]);
    }

    public function actionForgotPassword($token)
    {
        $this->layout = 'withoutHeader';
        $model = new ForgotPassword();
        $model->token = $token;
        if ($this->request->isPost && $model->load($this->request->post())){
            if ($model->changePassword()){
                return $this->redirect('/site/');
            }
        }
        
        return $this->render('forgotPassword', [
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


    public function actionEventLikes()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
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

    public function actionEventUser()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Event::find()->rightJoin('event_user', 'event_user.eventId = event.id')->where(['event_user.userId' => Yii::$app->user->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
                ]);
        return $this->render('eventUser', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEventAll()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
        return $this->render('eventAll', []);
    }

    public function actionEventUpcoming()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
        $userGenres = GenreUser::find()->select('genreId')->where(['userId'=> Yii::$app->user->id])->asArray()->column();
        if (Yii::$app->user->identity->isUser) {
            
            $query = Event::find()->where(['genreId' => $userGenres]);
        } else {
            $query = Event::find();
        }
        $eventsSoon = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_ASC
                ]
                ],
        ]);
        return $this->render('eventUpcoming', [
            'eventsSoon' => $eventsSoon,
        ]);
    }

    public function actionEventNew()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
        $userGenres = GenreUser::find()->select('genreId')->where(['userId'=> Yii::$app->user->id])->asArray()->column();
        if (Yii::$app->user->identity->isUser) {
            
            $query = Event::find()->where(['genreId' => $userGenres]);
        } else {
            $query = Event::find();
        }
        $eventsNew = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'createdAt' => SORT_DESC,
                    ]
                ],
        ]);
        return $this->render('eventNew', [
            'eventsNew' => $eventsNew,
        ]);
    }

    public function actionView($id)
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
        $model = $this->findModel($id);
        $artistsModel = Artist::getArtistsByEventId($model->id);
        if ($this->request->isPost){
            if (!EventUser::getIsSignedUp($model->id)){
                
                $eventUser = new EventUser();
                $eventUser->userId = Yii::$app->user->id;
                $eventUser->eventId = $model->id;
                $eventUser->save();
            } else {
                $eventUser = EventUser::findOne(['userId' => Yii::$app->user->id, 'eventId' => $model->id]);
                $eventUser->delete();
            }
        }
        return $this->render('view', [
            'model' => $model,
            'artistsModel' => $artistsModel

        ]);
    }

    public function actionLike($id)
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/site/welcome');
        } elseif (Yii::$app->user->identity->isUser && !GenreUser::getGenresByUser()){
            return $this->redirect('/site/genres');
        }
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

    public function actionGenres(){
    $this->layout = 'withoutHeader';
    if (Yii::$app->user->isGuest){
        return $this->redirect('/site/welcome');
    } elseif (!Yii::$app->user->identity->isUser || GenreUser::getGenresByUser())
        $this->redirect('/site/');
        $model = new GenreUser();
        $genres = Genre::getGenres();
        $genreSelectArray = GenreUser::find()->select('genreId')->where(['userId'=> Yii::$app->user->id])->asArray()->column();
    
    if ($genreSelectArray){
        return $this->redirect('/site/');
    }
        if ($this->request->isPost && $model->load($this->request->post())){
            if ($model->validate()){
                GenreUser::deleteAll(['userId'=> Yii::$app->user->id]);
                foreach ($model->selectedGenres as $key => $value) {
                    $genreUserModel = new GenreUser();
                    $genreUserModel->userId = Yii::$app->user->id;
                    $genreUserModel->genreId = $value;
                    $genreUserModel->save(false);
                }
                return $this->redirect('/');
            }
        }
        return $this->render('genres', [
            'model' => $model,
            'genres' => $genres,
        'genreSelectArray' => $genreSelectArray
        ]);
    }
   
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        throw new NotFoundHttpException('The requested page does not exist.');

    }
}
