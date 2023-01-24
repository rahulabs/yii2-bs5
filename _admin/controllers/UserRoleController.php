<?php

namespace backend\controllers;

use common\models\UserToPages;
use Yii;
use common\models\UserRole;
use common\models\UserRoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * UserRoleController implements the CRUD actions for UserRole model.
 */
class UserRoleController extends Controller
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
                        'actions' => ['index','delete','create','update','view','permissions'],
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
     * Lists all UserRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserRoleSearch();
        $searchModel->is_delete = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserRole model.
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
     * Creates a new UserRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserRole();

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                if($model->menu_id){
                    foreach ($model->menu_id as $menu_id){
                        if($menu_id){
                            $parent_id = 0;
                            $menu_id = explode('_',$menu_id);
                            $main_id = $menu_id[0];
                            if(isset($menu_id[1])){
                                $parent_id = $menu_id[0];
                                $main_id = $menu_id[1];
                            }
                            $pages_model = New UserToPages();
                            $pages_model->role_id = $model->role_id;
                            $pages_model->parent_id = $parent_id;
                            $pages_model->menu_id = $main_id;
                            $pages_model->save();

                        }

                    }
                }

                \Yii::$app->session->setFlash('success', 'Your record has been added successfully.');
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'permissions' => 0,
        ]);
    }

    /**
     * Updates an existing UserRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                UserToPages::deleteAll(['role_id' => $model->role_id]);
                if($model->menu_id){

                    foreach ($model->menu_id as $menu_id){
                        if($menu_id){
                            $parent_id = 0;
                            $menu_id = explode('_',$menu_id);
                            $main_id = $menu_id[0];
                            if(isset($menu_id[1])){
                                $parent_id = $menu_id[0];
                                $main_id = $menu_id[1];
                            }
                            $pages_model = New UserToPages();
                            $pages_model->role_id = $model->role_id;
                            $pages_model->parent_id = $parent_id;
                            $pages_model->menu_id = $main_id;
                            $pages_model->save();
                        }
                    }
                }
                \Yii::$app->session->setFlash('success', 'Your record has been updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        if((int)$id === 1){
            throw new ForbiddenHttpException(Yii::t('app', 'Permission denied.'));
        }
        $model = $this->findModel($id);
        $model->is_delete = 1;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Your record has been deleted successfully.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserRole::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionPermissions($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                UserToPages::deleteAll(['role_id' => $model->role_id]);
                if($model->menu_id){

                    foreach ($model->menu_id as $menu_id){
                        if($menu_id){
                            $parent_id = 0;
                            $menu_id = explode('_',$menu_id);
                            $main_id = $menu_id[0];
                            if(isset($menu_id[1])){
                                $parent_id = $menu_id[0];
                                $main_id = $menu_id[1];
                            }
                            $pages_model = New UserToPages();
                            $pages_model->role_id = $model->role_id;
                            $pages_model->parent_id = $parent_id;
                            $pages_model->menu_id = $main_id;
                            $pages_model->save();
                        }
                    }
                }
                \Yii::$app->session->setFlash('success', 'Your record has been updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'permissions' => 1,
        ]);
    }
}
