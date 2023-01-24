<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use common\models\Language;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;

$all_languages = Language::find()->where(['status' => 1])->asArray()->all();
$flags = [];
foreach ($all_languages as $all_language):
    $flag = Html::img(Yii::$app->request->baseUrl.'/images/flags/'.$all_language['image'],['class' => 'img-fluid','alt' => $all_language['name'],'title' => $all_language['name'], 'width' => 20]);
    $flags[$all_language['language_id']] = $flag;
endforeach;
?>
<div class="page-index">
    <p class="float-end">
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-outline-dark btn-sm']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data){
                    return $data->pagesDescription['title'];
                }
            ],
            [
                'attribute'=>'status',
                'filter'=>Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => [ 1 => 'Active', 0 => 'Inactive'],
                    'options' => [
                        'placeholder' => 'Please select ...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value'=>function($data){
                    return $data->status == 1 ? 'Active' : 'Inactive';
                }
            ],
            'page_order',
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
                'filter'=>false
            ],

            ['class' => 'common\component\ActionColumn'],
        ],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'pageCssClass' => 'page-item',
            'disabledPageCssClass' => 'page-link disabled',
            'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
            'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
            'linkOptions' => ['class' => 'page-link'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
