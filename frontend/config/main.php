<?php

use common\models\User;
use \yii\web\Request;
use yii\helpers\Url;
use common\models\Settings;
use common\models\Redirect;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'on beforeAction' => static function ($event) {
        $url =  \Yii::$app->request->url;
        $redirect = Redirect::find()->where(['from' => $url])->asArray()->one();
        if($redirect){
            return \Yii::$app->getResponse()->redirect($redirect['to'],$redirect['redirect_type'])->send();
        }
        define('website_url', Url::to(\Yii::$app->request->baseUrl . '/', true)); //define default url

        $settings = Settings::find()->asArray()->all();
        foreach($settings as $Setting){
            define($Setting['settings_key'],$Setting['settings_value']); //define default setting values
        }
    },
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => $baseUrl,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<alias:index|about|contact>' => 'site/<alias>',
            ],
        ],

    ],
    'params' => $params,
];
