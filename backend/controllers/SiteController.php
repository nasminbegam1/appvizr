<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'blank.php';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','login', 'error','forgotpassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['user/dashboard'],302);
        }
        return $this->redirect(['site/login'],302);
        //return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['user/dashboard'],302);
            //return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionForgotpassword(){
        $model      = new User;
        
        $model->scenario = 'forgotPassword';
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $model->password            = Yii::$app->security->generateRandomString(6);
            
            $body                       = '';
        
            $mailSend = Yii::$app->mailer->compose('@app/views/site/email',['model'=>$model])
                ->setTo($model->email)
                ->setFrom(['nasmin.begam@webskitters.com' => 'appvizr'])
                ->setSubject('New Password')
                ->setTextBody($body)
                ->send();
               
            if($mailSend){
                $user                    = User::findOne(['email' => $model->email]);
                $user->password_hash     = Yii::$app->security->generatePasswordHash($model->password);
                $user->save();
                
                \Yii::$app->getSession()->setFlash('success', 'A Mail has been to your e-mail id.');
                return $this->refresh();
            }
        } else {
            return $this->render('forgotPassword', [
                'model' => $model,
            ]);
        }
        
    }
    
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
