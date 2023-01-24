<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('app', 'Update Page: {name}', [
    'name' => $model->page_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pagesDescriptions[0]->title, 'url' => ['view', 'id' => $model->page_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="page-update">
    <div class="d-flex align-items-center justify-content-between">
        <p>&nbsp;</p>
        <?= Html::a('Back',['index'],['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
