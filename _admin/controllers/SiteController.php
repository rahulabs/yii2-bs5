<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Users;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','clear','password'],
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
     * {@inheritdoc}
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        $model->disallowRule = [1];
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionClear(){
        if (\Yii::$app->cache->flush()) {
            Yii::$app->assetsCache->flush(); // frontend assets folder
            Yii::$app->bAssetsCache->flush(); // backend assets folder

            Yii::$app->debugCache->flush(); // frontend debug folder
            Yii::$app->bDebugCache->flush(); // backend debug folder

            Yii::$app->logsCache->flush(); // frontend log folder
            Yii::$app->bLogsCache->flush(); // backend log folder

            Yii::$app->mailCache->flush(); // frontend mail folder
            Yii::$app->bMailCache->flush(); // backend mail folder

            Yii::$app->frontendCache->flush(); // frontend assets cache
            Yii::$app->bFrontendCache->flush(); // backend assets cache

            \Yii::$app->session->addFlash('success', Yii::t('app','Cache cleared'));
        } else {
            \Yii::$app->session->addFlash('error', Yii::t('app','Cannot clear cache'));
        }
        return $this->goBack(Yii::$app->request->referrer);
    }

    public function actionPassword(){
        $model = Users::findOne(Yii::$app->user->id);

        $model->scenario = 'change_password';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            if($model->save()){
                \Yii::$app->session->setFlash('success', 'Your password has been changed successfully.');
                return $this->refresh();
            }
        }
        return $this->render('password',
            ['model' => $model]
        );
    }
}
