<?php

use common\models\AdminPage;
use common\models\Settings;
use common\models\UserRole;
use common\models\UserToPages;
use yii\caching\FileCache;
use yii\web\ForbiddenHttpException;
use \yii\web\Request;
use yii\helpers\Url;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$baseUrl = str_replace('/_admin/web', '/admin', (new Request)->getBaseUrl());
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'on beforeAction' => function ($event) {
        define('website_url', Url::to(\Yii::$app->request->baseUrl . '/', true)); //define default url

        $settings = Settings::find()->asArray()->all();
        foreach($settings as $Setting){
            define($Setting['settings_key'],$Setting['settings_value']); //define default setting values
        }
        Yii::$container->set('lgxenos\yii2\imgSelector\ImageSelector', [
            'fileManagerPathTpl' => config_website_url.'/responsive_filemanager/filemanager/dialog.php?type=2&field_id=%s&relative_url=0&callback=ImageSelectorCallBack'
        ]);
        if(!Yii::$app->user->isGuest){
            $allowed_url = ['site','default'];
            $allow = false;
            $controller =  Yii::$app->controller->id;
            $action =  Yii::$app->controller->action->id;

            $user = Yii::$app->user->identity;
            $role_id = $user->role_id;
            define('role_id',$role_id);
            if(in_array($controller, $allowed_url)){
                $allow = true;
            }else{
                $roles[] = $role_id;
                if ($user->other_roles) {
                    foreach (explode(',', $user->other_roles) as $role){
                        $roles[] = $role;
                    }
                }
                define('all_roles',$roles);
                $role = UserRole::findOne($role_id);
                if($role){
                    $admin_page = AdminPage::find()->where(['config_value' => $controller])->one();
                    if($admin_page){
                        $session = Yii::$app->session;
                        $session->set('current_page',$admin_page->id);
                        $id = $admin_page->id;

                        $permissions = [];
                        $user_to_pages = UserToPages::find()->select('menu_id')->where(['IN', 'role_id', $roles])->all();
                        if($user_to_pages){
                            foreach ($user_to_pages as $user_to_page){
                                $permissions[] = $user_to_page->menu_id;
                            }
                        }
                        $all_permissions = $permissions;
                        if(in_array($id, $all_permissions, true)){
                            $allow = true;
                        }
                    }

                }
            }
            if(!$allow){
                throw new ForbiddenHttpException('You are not allowed to access this page.');
            }
        }
    },
    'components' => [
        'assetsCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@frontend') . '/web/assets'
        ],
        'bAssetsCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@backend') . '/web/assets'
        ],

        'debugCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/debug'
        ],
        'bDebugCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@backend') . '/runtime/debug'
        ],

        'logsCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/logs'
        ],
        'bLogsCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@backend') . '/runtime/logs'
        ],

        'mailCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/mail'
        ],
        'bMailCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@backend') . '/runtime/mail'
        ],

        'frontendCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
        ],
        'bFrontendCache' => [
            'class' => FileCache::class,
            'cachePath' => Yii::getAlias('@backend') . '/runtime/cache'
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => $baseUrl
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
                '<alias:clear>' => 'site/<alias>',
            ],
        ],
    ],
    'params' => $params,
];
