<?php

use common\component\ActionColumn;
use common\models\UserRole;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <p class="float-end">
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-outline-dark btn-sm']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => [10 => 'Active', 9 => 'Inactive'],
                'value' => static function($model){
                    return $model->status === 10 ? 'Active' : 'In active';
                },
                'filterInputOptions' => ['class' => 'form-select']
            ], [
                'attribute' => 'role_id',
                'format' => 'raw',
                'filter' => ArrayHelper::map(UserRole::find()->asArray()->all(), 'role_id', 'name'),
                'value' => static function($model){
                    $roles[] = $model->role->name;
                    if ($model->other_roles) {
                        foreach (explode(', ',$model->other_roles) as $role) {
                            $roleModel = UserRole::findOne($role);
                            if ($roleModel) {
                                $roles[] = $roleModel->name;
                            }
                        }
                    }
                    return implode(',', $roles);
                },
                'filterInputOptions' => ['class' => 'form-select']
            ], ['class' => ActionColumn::class,
                'template' => '{update-status} {update} {delete}',
                'visibleButtons' => [
                    'delete' => static function($model){
                        return $model->id !== 1;
                    }
                ],
                'buttons' => [
                    'update-status' => function($url, $model, $key){
                        $icon = '<i class="fas fa-toggle-off"></i>';
                        $title = 'Inactive';
                        $confirm_text = 'Are you sure want to active this user?';
                        if($model->status === 10){
                            $confirm_text = 'Are you sure want to in active this user?';
                            $title = 'Active';
                            $icon = '<i class="fas fa-toggle-on"></i>';
                        }
                        return Html::a($icon,$url,['data-pjax' => 0,'title'=> $title,'data-confirm' => $confirm_text,'class' => 'btn btn-sm btn-outline-dark ms-1']);

                    },
                    'login'=>function($url, $model, $key){
                        return Html::a(Html::tag('i','',['class'=>'fas fa-sign-in-alt']),['../../site/auto-login','id'=>$model->id],['target' => '_blank','data-pjax'=>0,'class'=>'btn btn-outline-dark btn-sm','title'=>'Login']);
                    },
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
