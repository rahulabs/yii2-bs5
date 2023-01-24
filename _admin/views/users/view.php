<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <p class="float-end">
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-sm btn-outline-dark']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status == 10 ? 'Active' : 'In active';
                }
            ],
            [
                'attribute' => 'role_id',
                'value' => function($model){
                    return $model->role->name;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',

        ],
    ]) ?>

</div>
