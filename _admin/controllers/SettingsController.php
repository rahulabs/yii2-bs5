<?php

namespace backend\controllers;

use Yii;
use common\models\Settings;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'error','create'],
						'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Settings();
		$results = $model->find()->all();
        $session = Yii::$app->session;
        $session->set('IsAuthorized',true);

		foreach($results as $result) {
			$model->{$result->settings_key} = $result->settings_value;
		}
		if(isset($_POST['Settings']))
		{
			$model->deleteAll();
			foreach($_POST['Settings'] as $key=>$value)
			{
			    if(is_array($value)) $value = implode(',',$value);
                $model_new = new Settings();
                $model_new->settings_key = $key;
                $model_new->settings_value = $value;
                $model_new->validate();

                $model_new->save();
			}
            Yii::$app->session->setFlash('success', 'Your settings has been updated successfully.');
			return $this->refresh();
		}
		
		 return $this->render('create', [
            'model' => $model
        ]);
		
    }
    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
