<?php

namespace backend\controllers;

use Yii;
use common\models\Page;
use common\models\PageSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PageDescription;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
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
                        'actions' => ['index','delete','create','update','view'],
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
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $searchModel->is_delete = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $titles = $model->title;
            $model->title = $titles[1];
            $description = $model->description;
            $meta_title = $model->meta_title;
            $meta_keyword = $model->meta_keyword;
            $meta_description = $model->meta_description;
            if($model->save()){
                foreach ($titles as $language_id => $title){
                    $page_description = new PageDescription();
                    $page_description->language_id = $language_id;
                    $page_description->page_id = $model->page_id;
                    $page_description->title = $title;
                    $page_description->description = $description[$language_id];
                    $page_description->meta_title = $meta_title[$language_id];
                    $page_description->meta_description = $meta_description[$language_id];
                    $page_description->meta_keyword = $meta_keyword[$language_id];
                    $page_description->save();
                }

                Yii::$app->session->setFlash('success', 'Your record has been added successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $titles = $model->title;
            $model->title = $titles[1];
            $description = $model->description;
            $meta_title = $model->meta_title;
            $meta_keyword = $model->meta_keyword;
            $meta_description = $model->meta_description;
            if($model->save()){
                PageDescription::deleteAll(['page_id' => $model->page_id]);

                foreach ($titles as $language_id => $title){
                    $page_description = new PageDescription();
                    $page_description->language_id = $language_id;
                    $page_description->page_id = $model->page_id;
                    $page_description->title = $title;
                    $page_description->description = $description[$language_id];
                    $page_description->meta_title = $meta_title[$language_id];
                    $page_description->meta_description = $meta_description[$language_id];
                    $page_description->meta_keyword = $meta_keyword[$language_id];
                    $page_description->save();
                }

                Yii::$app->session->setFlash('success', 'Your record has been updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_delete = 1;
        $model->save();

        \Yii::$app->session->setFlash('success', 'Your record has been deleted successfully.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne(['page_id' => $id,'is_delete' => 0])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
