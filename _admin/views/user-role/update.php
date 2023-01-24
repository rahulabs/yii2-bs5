<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserRole */

$this->title = Yii::t('app', 'Update User Role: {name}', [
    'name' => $model->name,
]);
$permissions = $permissions ?? 0;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] =    !$permissions ? Yii::t('app', 'Update') : 'Permissions';

?>
<div class="user-role-update">
    <div class="d-flex align-items-center justify-content-between">
        <p>&nbsp;</p>
        <?= Html::a('Back',['index'],['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'permissions' => $permissions,
    ]) ?>

</div>
