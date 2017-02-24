<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response_data = $response->data;
                
                if ($response_data !== null && $response->statusCode < 400 && !array_key_exists('error',$response_data)) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response_data,
                        'status' => $response->statusCode,
                    ];
                    $response->statusCode = 200;
                }
                else if($response_data !=null && array_key_exists('message',$response_data) && $response_data['message']<>'' && $response_data['error']==true) {
                    $data_display = array();
                    if(array_key_exists('data',$response_data) && $response_data['message']<>'') {
                      $data_display = $response_data['data'];
                    }
                        $response->data = [
                            'success' => false,
                            'message' => $response_data['message'],
                            'data' => $data_display,
                            'status' => $response->statusCode,
                        ];
                    
               }
               /*else {
               $response->data = [
                'success' => false,
                'data' => $response->data,
                'status' => $response->statusCode,   
             ];
                }*/
            },
           
        ],
        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' =>['v1/country','v1/category','v1/qualification','v1/subcategory','v1/customer','v1/consultant','v1/favourite','v1/rating','v1/callhistory'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST getlist'                      => 'getlist',
                        'POST login'                        => 'login',
                        'POST profilepicture'               => 'profilepicture',
                        'POST changepassword'               => 'changepassword',
                        'POST consultantsearch'             => 'consultantsearch',
                        'POST consultantlogin'              => 'consultantlogin',
                        'POST consultantprofilepicture'     => 'consultantprofilepicture',
                        'POST consultantchangepassword'     => 'consultantchangepassword',
                        'POST setprice'                     => 'setprice',
                        'POST favouritelist'                => 'favouritelist',
                        'POST totalrate'                    => 'totalrate',
                        'POST consultentlist'               => 'consultentlist',
                        'POST callhistory'                  => 'callhistory',
                        'POST notification'                 => 'notification',
                        'POST callhistorylist'              => 'callhistorylist',
                        'POST notificationlist'             => 'notificationlist'
                    ],
                    
                ]
            ],        
        ],
         'urlManagerFront' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'http://182.73.137.51/appvizr/',
        ]
      
    ],
    'params' => $params,
];