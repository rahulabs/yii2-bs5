<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->pagesDescriptions[0]->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$pagesDescription = $model->pagesDescription;
?>
<div class="card">
    <div class="card-body">
        <p class="float-end">
            <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-sm btn-outline-dark']) ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->page_id], ['class' => 'btn btn-success btn-sm']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->page_id], [
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
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => function ($data) use($pagesDescription){
                        return $pagesDescription['title'];
                    }
                ],
                [
                    'attribute'=>'status',
                    'value'=>function($data){
                        return $data->status==1 ? 'Active' : 'Inactive';
                    }
                ],
                'page_order',
                [
                    'attribute' => 'description',
                    'format' => 'raw',
                    'value' => function ($data) use($pagesDescription){
                        return $pagesDescription['description'];
                    }
                ],
                [
                    'attribute' => 'meta_title',
                    'format' => 'raw',
                    'value' => function ($data) use($pagesDescription){
                        return $pagesDescription['meta_title'];
                    }
                ],
                [
                    'attribute' => 'meta_description',
                    'format' => 'raw',
                    'value' => function ($data) use($pagesDescription){
                        return $pagesDescription['meta_description'];
                    }
                ],
                [
                    'attribute' => 'meta_keyword',
                    'format' => 'raw',
                    'value' => function ($data) use($pagesDescription){
                        return $pagesDescription['meta_keyword'];
                    }
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>

    </div>
</div>
