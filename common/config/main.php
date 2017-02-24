<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'helpers' => [
              'class' => 'common\components\Helpers',
        ],
        'urlManagerFrontend' => [
                'class' => 'yii\web\urlManager',
                'baseUrl' => 'http://182.73.137.51/appvizr',
             
               
        ],
    ],
];
