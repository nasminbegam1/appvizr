<?php
namespace common\components;
use Yii;
 
class Helpers
{
    public static function  isActiveRoute($controller_id, $action_id , $output = "active")
    {
            if (Yii::$app->controller->id == $controller_id && Yii::$app->controller->action->id == $action_id) return $output;
    }
}
?>