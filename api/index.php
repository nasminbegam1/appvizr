<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require('/var/www/html/appvizr/vendor/autoload.php');
require('/var/www/html/appvizr/vendor/yiisoft/yii2/Yii.php');
require('/var/www/html/appvizr/common/config/bootstrap.php');
require('/var/www/html/appvizr/api/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require('/var/www/html/appvizr/common/config/main.php'),
    require('/var/www/html/appvizr/common/config/main-local.php'),
    require('/var/www/html/appvizr/api/config/main.php'),
    require('/var/www/html/appvizr/api/config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();
