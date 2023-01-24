<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UsersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','delete','create','update','view','update-status'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete'=>['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $searchModel->is_delete = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->other_roles && is_array($model->other_roles)) {
                $model->other_roles = implode(',', $model->other_roles);
            }
            if($model->password){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }
            if($model->save()){
                \Yii::$app->session->setFlash('success', 'Your record has been updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->other_roles && is_array($model->other_roles)) {
                $model->other_roles = implode(',', $model->other_roles);
            }
            if($model->password){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }
            if($model->save()){
                \Yii::$app->session->setFlash('success', 'Your record has been updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if((int)$id === 1){
            throw new ForbiddenHttpException(Yii::t('app', 'Permission denied.'));
        }
        $model = $this->findModel($id);
        $model->is_delete = 1;
        $model->status = 9;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Your record has been deleted successfully.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id,'is_delete' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @throws \yii\base\Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdateStatus($id){
        $model = $this->findModel($id);
        if($model->status === 9){
            $model->status = 10;
        }elseif($model->status === 10){
            $model->status = 9;
            $model->auth_key = \Yii::$app->security->generateRandomString();
        }
        $model->save();
        return $this->goBack(Yii::$app->request->referrer);
    }
}
