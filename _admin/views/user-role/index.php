<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel common\models\UserRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role-index col">
    <p class="float-end">
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-outline-dark btn-sm']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table_custom table-hover table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            ['class' => 'common\component\ActionColumn',
                'visibleButtons' => [
                    'delete' => function($model){
                        return $model->role_id!=1;
                    }
                ],
                'template' => '{permissions} {update} {delete}',
                'buttons' => [
                    'permissions' => function($url, $model, $key){
                        return Html::a('<i class="fas fa-key"></i>',$url, ['data-pjax' => 0,'alt'=> 'Permissions','title'=> 'Permissions','class'=>'btn btn-sm btn-outline-dark ms-1']);
                    }
                ]
            ],
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
