<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = Yii::t('app', 'Update Users: {name}', [
    'name' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-update">
    <div class="d-flex align-items-center justify-content-between">
        <p>&nbsp;</p>
        <?= Html::a('Back',['index'],['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
