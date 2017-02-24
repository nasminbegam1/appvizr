<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\helpers\Url;

class BaseController extends Controller
{
    //public $layout = 'blank.php';
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            
            $this->redirect(Url::toRoute('/site/login'));
            return false;
        
        } 
        return true;
        
    }
}
